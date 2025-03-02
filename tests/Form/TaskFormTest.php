<?php

namespace App\Tests\Form;

use App\Entity\Task;
use App\Form\TaskForm;
use App\Tests\TestCase\AbstractApplicationTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;

/**
 * Class TaskFormTest
 * @package App\Tests\Form
 */
class TaskFormTest extends AbstractApplicationTestCase
{
    public const TEST_TASK_TITLE = "Valid Task Title";

    /** @var FormInterface $form */
    protected FormInterface $form;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new ValidatorExtension(Validation::createValidator()))
            ->getFormFactory();

        $this->form = $formFactory->create(TaskForm::class, new Task());
    }

    /**
     * @return void
     */
    public function testFormStructure(): void
    {
        $this->assertCount(2, $this->form->all());
        $this->assertTrue($this->form->has(TaskForm::FORM_ELEMENT_NAME_TITLE));
        $this->assertTrue($this->form->has(TaskForm::FORM_ELEMENT_NAME_SUBMIT));
    }

    /**
     * @return void
     */
    public function testValidFormSubmission(): void
    {
        $this->form->submit([TaskForm::FORM_ELEMENT_NAME_TITLE => self::TEST_TASK_TITLE]);

        $this->assertTrue($this->form->isValid());
        $this->assertInstanceOf(Task::class, $this->form->getData());
        $this->assertEquals(self::TEST_TASK_TITLE, $this->form->getData()->getTitle());
    }
}
