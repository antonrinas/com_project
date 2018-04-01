<?php

use PHPUnit\Framework\TestCase;
use Api\Validator\Comment;
use Main\Validator\BaseValidatorInterface;

class CommentValidatorTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- API: CommentValidator tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $validator = new Comment();
        $this->assertInstanceOf(
            Comment::class,
            $validator
        );

        return $validator;
    }

    /**
     * @param BaseValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testCanFilter($validator)
    {
        echo PHP_EOL . "    ---- Can filter test" . PHP_EOL;
        $validator->setFormData([
            'user_name' => "    <script>alert('test')</script>\'    ",
            'content' => "    <script>alert('test')</script>\"     ",
        ]);
        $validator->isValid();
        $this->assertSame(
            [
                'user_name' => "alert('test')'",
                'content' => "alert('test')\"",
            ],
            $validator->getFormData()
        );
    }

    /**
     * @param BaseValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testCanValidateEmptiness($validator)
    {
        echo PHP_EOL . "    ---- Can validate emptiness test" . PHP_EOL;
        $validator->setFormData([
            'user_name' => "",
            'content' => "",
        ]);
        $validator->isValid();
        $this->assertSame(
            [
                'user_name' => "Поле не может быть пустым",
                'content' => "Поле не может быть пустым",
            ],
            $validator->getErrors()
        );
    }

    /**
     * @param BaseValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testCanValidateTooLong($validator)
    {
        echo PHP_EOL . "    ---- Can validate too long values test" . PHP_EOL;
        $validator->setFormData([
            'user_name' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
            'content' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
        ]);
        $validator->isValid();
        $this->assertSame(
            [
                'user_name' => "Длина должна быть от 0 до 255 символов",
                'content' => "Длина должна быть от 0 до 500 символов",
            ],
            $validator->getErrors()
        );
    }

    /**
     * @param BaseValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testCanValidateValidValues($validator)
    {
        echo PHP_EOL . "    ---- Can validate valid values test" . PHP_EOL;
        $validator->setFormData([
            'user_name' => 'test',
            'content' => 'test',
        ]);
        $this->assertTrue($validator->isValid());
    }
}