<?php

namespace App\Builder\Views\Commands;

use App\Contracts\Builder\Views\Commands\Command as CommandContract;
use App\Builder\Views\Commands\Command;

use App\Builder\Views\TemplateCompiler;

class ShowValidationErrorCommand extends Command implements CommandContract
{
    private const HTML_CODE = '<?php if (session()::hasErrors()): ?>
                                    <ul>
                                        <?php foreach (session()::popErrors() as $errors): ?>
                                            <?php foreach ($errors as $error): ?>
                                                <li><?=$error?></li>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>';

    public function handler($parameter)
    {
        $this->compiler->setResultContent(
            str_replace(
                '{{show-validation-errors}}',
                self::HTML_CODE,
                $this->compiler->getResultContent()
            )
        );
    }
}