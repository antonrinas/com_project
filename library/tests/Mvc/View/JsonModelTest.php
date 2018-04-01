<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\View\JsonModel;
use Framework\Mvc\View\JsonModelInterface;

class JsonModelTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: JsonModel tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $jsonModel = new JsonModel();
        $this->assertInstanceOf(
            JsonModel::class,
            $jsonModel
        );

        return $jsonModel;
    }

    /**
     * @param JsonModelInterface $jsonModel
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetData($jsonModel)
    {
        echo PHP_EOL . "    ---- Can set/get data test" . PHP_EOL;
        $jsonModel->setParams(['param1' => 'value1', 'param2' => 'value2']);
        $this->assertSame(['param1' => 'value1', 'param2' => 'value2'], $jsonModel->getParams());
        return $jsonModel;
    }

    /**
     * @param JsonModelInterface $jsonModel
     * @depends clone testCanSetGetData
     */
    public function testCanRender($jsonModel)
    {
        echo PHP_EOL . "    ---- Can render test" . PHP_EOL;
        $this->assertSame('{"param1":"value1","param2":"value2"}', $jsonModel->render());
    }
}