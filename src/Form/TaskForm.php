<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class TaskForm
 * @package App\Form
 */
class TaskForm extends AbstractType
{
    public const FORM_NAME = "task-form";
    public const FORM_ELEMENT_NAME_TITLE = "title";
    public const FORM_ELEMENT_NAME_SUBMIT = "submit";
    public const LABEL_TITLE = "New task";
    public const ERROR_TITLE_BLANK = "Please enter a task title";
    public const ERROR_TITLE_MIN = "Task title must be at least {{ limit }} characters";
    public const ERROR_TITLE_MAX = "Task title cannot be longer than {{ limit }} characters";
    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 255;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::FORM_ELEMENT_NAME_TITLE, TextType::class, $this->getTitleFieldElementConfig())
            ->add(self::FORM_ELEMENT_NAME_SUBMIT, SubmitType::class, $this->getSubmitButtonElementConfig());
    }

    /**
     * @return array
     */
    protected function getTitleFieldElementConfig(): array
    {
        return [
            "constraints" => [
                new NotBlank(["message" => self::ERROR_TITLE_BLANK]),
                new Length([
                    "min" => self::MIN_LENGTH,
                    "max" => self::MAX_LENGTH,
                    "minMessage" => self::ERROR_TITLE_MIN,
                    "maxMessage" => self::ERROR_TITLE_MAX,
                ])
            ],
            "attr" => [
                "class" => "border p-2 flex-grow rounded-l",
                "placeholder" => self::LABEL_TITLE . "...",
            ],
            "label" => self::LABEL_TITLE,
        ];
    }

    /**
     * @return array
     */
    protected function getSubmitButtonElementConfig(): array
    {
        return [
            "label" => "Add",
            "attr" => [
                "class" => "bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600"
            ],
        ];
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(["data_class" => Task::class, "csrf_protection" => true,]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return self::FORM_NAME;
    }
}
