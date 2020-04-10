<?php

namespace Revolution\LaminasForm\Tests;

use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Renderer\RendererInterface;
use Revolution\LaminasForm\Form;

class FormTest extends TestCase
{
    public function testInstance(): void
    {
        $form = new Form;
        $this->assertInstanceOf(Form::class, $form);
    }

    /**
     * @param string $formHelper
     * @testWith    ["anyOtherHelperMethodThatNoBodyWouldImplement"]
     *              ["anyOtherHelperMethodThatNoBodyWouldImplementEver"]
     * @throws \Laminas\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testRenderThrowsBadMethodCallExceptionOnWrongHelper(string $formHelper): void
    {
        $this->expectException(ServiceNotFoundException::class);
        $form = new Form();
        $form->render($formHelper);
    }

    public function testRender(): void
    {
        $form = new TestForm();

        $this->assertStringContainsString('<form', (string)$form->render());
    }

    public function testOpenTag(): void
    {
        $form = new TestForm();

        $this->assertStringContainsString('<form', $form->form()->openTag($form));
    }

    public function testInput(): void
    {
        $form = new TestForm();

        $this->assertStringContainsString('<input type="text" name="name"', $form->formInput($form->get('name')));
    }

    public function testRenderer(): void
    {
        $renderer = app(RendererInterface::class);

        $this->assertInstanceOf(PhpRenderer::class, $renderer);
    }

    public function testHelperBSHorizon(): void
    {
        $form = new TestForm();

        $html = $form->bootstrap4horizon($form);

        //dump($html);

        $this->assertStringContainsString('form-text text-muted', $html);
    }

    public function testHelperUIHorizon(): void
    {
        $form = new TestForm();

        $html = $form->uikit3horizon($form);

        //dump($html);

        $this->assertStringContainsString('uk-text-meta', $html);
    }

    public function testFormRenderWithHelper(): void
    {
        $form = new TestForm();

        $html = (string)$form->render('bootstrap4horizon');

        //dump($html);

        $this->assertStringContainsString('form-text text-muted', $html);
    }
}
