<?php

namespace Blog\Mapper;

use Blog\Model\Post;
use Blog\Model\PostInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Debug\Debug;
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;

class ZendDbSqlMapper implements PostMapperInterface
{

    /**
     * @var AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var object
     */
    protected $prototypeObject;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var string
     */
    protected $table;

    public function __construct(AdapterInterface $dbAdapter, $prototypeObject, HydratorInterface $hydrator, $table)
    {
        $this->dbAdapter = $dbAdapter;
        $this->prototypeObject = $prototypeObject;
        $this->hydrator = $hydrator;
        $this->table = $table;
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql
            ->select($this->table)
            ->where(['id = ?' => $id]);
            //->where(['id = ?' => $id]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        /* dump prepared query */# Debug::dump($stmt->getSql(), $id);die();

        $result = $stmt->execute();
        /* dump all interfaces */# Debug::dump(class_implements($result));die();

        if($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()){
            return $this->hydrator->hydrate($result->current(), $this->prototypeObject);
        }

        throw new \InvalidArgumentException("Post with id:{$id} not found");
    }

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($this->table);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $resultSet = new HydratingResultSet(new ClassMethods(), new Post());
        return $resultSet->initialize($result);
    }

    /**
     * @inheritDoc
     */
    public function save(PostInterface $post)
    {
        if($post->getId()){
            $post = $this->update($post);
        }else{
            $post = $this->create($post);
        }

        return $post;
    }

    protected function update(PostInterface $post){
        $postData = $this->hydrator->extract($post);
        unset($postData['id']); // not necessary for either save or create

        $update = new Update($this->table);
        $update->set($postData);
        $update->where(['id = ?' => $post->getId()]);

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){
            return $post;
        }

        throw new \Exception("Database error");
    }

    protected function create(PostInterface $post){

        $postData = $this->hydrator->extract($post);
        unset($postData['id']); // not necessary for either save or create

        $insert = new Insert($this->table);
        $insert->values($postData);

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){
            $post->setId($result->getGeneratedValue());
            return $post;
        }

        throw new \Exception('Database error');
    }

    /**
     * @inheritDoc
     */
    public function delete(PostInterface $post)
    {
        $delete = new Delete($this->table);
        $delete->where(['id = ?' => $post->getId()]);

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($delete);
        $result = $stmt->execute();

        if($result instanceof ResultInterface){
            return (bool)$result->getAffectedRows();
        }

        throw new \Exception('Database error');
    }


}