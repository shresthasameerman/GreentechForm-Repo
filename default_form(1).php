<div class="com-contact__form contact-form">
    <form id="contact-form" action="<?php echo \Joomla\CMS\Router\Route::_('index.php'); ?>" method="post" class="form-validate form-horizontal well">
        <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
            <?php if ($fieldset->name === 'captcha' && $this->captchaEnabled) : ?>
                <?php continue; ?>
            <?php endif; ?>
            <?php $fields = $this->form->getFieldset($fieldset->name); ?>
            <?php if (count($fields)) : ?>
                <fieldset class="m-0">
                    <?php foreach ($fields as $field) : ?>
                        <?php if ($field->name === 'contact_phone') : ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <?php echo $field->renderField(); ?>
                    <?php endforeach; ?>
                </fieldset>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- Captcha fieldset, if enabled -->
        <?php if ($this->captchaEnabled) : ?>
            <?php echo $this->form->renderFieldset('captcha'); ?>
        <?php endif; ?>
        <!-- Submit button -->
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary validate" type="submit">Send an Email</button>
                <input type="hidden" name="option" value="com_contact">
                <input type="hidden" name="task" value="contact.submit">
                <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
                <input type="hidden" name="id" value="<?php echo $this->item->slug; ?>">
                <?php echo \Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
            </div>
        </div>
    </form>
</div>
