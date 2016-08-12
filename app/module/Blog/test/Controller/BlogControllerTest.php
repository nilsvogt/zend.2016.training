<?php
namespace BlogTest\Controller;

use Blog\Controller\ListController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BlogControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = false;

    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            // Grabbing the full application configuration:
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/blog');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Blog');
        $this->assertControllerName(ListController::class);
        $this->assertControllerClass('BlogController');
        $this->assertMatchedRouteName('blog');
    }
}