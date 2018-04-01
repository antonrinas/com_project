<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\View\ViewModel;
use Framework\Mvc\View\ViewModelInterface;

class ViewModelTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: ViewModel tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $viewModel = new ViewModel();
        $this->assertInstanceOf(
            ViewModel::class,
            $viewModel
        );

        return $viewModel;
    }

    /**
     * @param ViewModelInterface $viewModel
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetData($viewModel)
    {
        echo PHP_EOL . "    ---- Can set/get data test" . PHP_EOL;
        $viewModel->setParams('params');
        $this->assertSame('params', $viewModel->getParams());
        $viewModel->setLayoutName('test-layout');
        $this->assertSame('test-layout', $viewModel->getLayoutName());
        $viewModel->setModuleConfig([
            'views_path' => ROOT . '/library/tests/Mvc/view-test/main',
            'layouts' => [
                'test-layout' => ROOT . '/library/tests/Mvc/view-test/layout/test-layout.php',
                'default' => ROOT . '/library/tests/Mvc/view-test/layout/default.php',
            ],
            'factories' => [
            ]
        ]);
        $this->assertSame(
            [
                'views_path' => ROOT . '/library/tests/Mvc/view-test/main',
                'layouts' => [
                    'test-layout' => ROOT . '/library/tests/Mvc/view-test/layout/test-layout.php',
                    'default' => ROOT . '/library/tests/Mvc/view-test/layout/default.php',
                ],
                'factories' => [
                ]
            ],
            $viewModel->getModuleConfig()
        );
        $viewModel->setControllerName('Index');
        $this->assertSame('Index', $viewModel->getControllerName());
        $viewModel->setMethodName('index');
        $this->assertSame('index', $viewModel->getMethodName());
        $viewModel->setParams([]);
        return $viewModel;
    }

    /**
     * @param ViewModelInterface $viewModel
     * @depends clone testCanSetGetData
     */
    public function testCanRender($viewModel)
    {
        echo PHP_EOL . "    ---- Can render test" . PHP_EOL;
        $this->assertSame('layout test view', $viewModel->render());
    }
}