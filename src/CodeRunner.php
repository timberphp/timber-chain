<?php

namespace Timberphp\TimberChain;

use Psy\Configuration;
use Psy\Shell;
use Psy\VersionUpdater\Checker;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;

class CodeRunner
{
    protected Shell $shell;

    protected OutputInterface $output;

    protected Detector $sherlock;

    protected string $targetPath;

    protected array $casters = [];

    protected string $outputMode;

    public function __construct($outputMode = 'buffered')
    {
        $this->outputMode = $outputMode;
        $this->output = $this->outputMode === 'stream' ? new StreamOutput(STDOUT) : new BufferedOutput();
        $this->sherlock = new Detector();
    }

    protected function makeShell(): CodeRunner
    {
        $config = new Configuration([
            'updateCheck' => Checker::NEVER,
            'configFile'  => null
        ]);
        if (!defined('PHP_WINDOWS_VERSION_BUILD')) {
            $config->setHistoryFile('/dev/null');
        }
        $config->getPresenter()->addCasters($this->casters);

        $this->shell = new Shell($config);
        $this->shell->setOutput($this->output);

        if (file_exists($composerClassMap = $this->targetPath . '/vendor/composer/autoload_classmap.php')) {
            ClassAliasAutoloader::register($this->shell, $composerClassMap);
        }

        return $this;
    }

    public function bootstrapAt(string $path = null): CodeRunner
    {
        $this->targetPath = $path ?? getcwd();

        $driver = $this->sherlock->detect($this->targetPath);

        $driver->rollOut($this->targetPath);

        $this->casters = $driver->casters();

        $this->makeShell();

        $this->teleportToTargetDirectory();

        return $this;
    }

    protected function teleportToTargetDirectory(): CodeRunner
    {
        if ($this->targetPath) {
            chdir($this->targetPath);
        }

        return $this;
    }

    /**
     * @param string $phpCode
     * @return string|void
     */
    public function execute(string $phpCode)
    {
        // result here is php variable
        $result = $this->shell->execute($this->removeComments($phpCode));

        // here we write to output to get raw string after processed by presenter
        $this->shell->writeReturnValue($result);

        if ($this->outputMode === 'buffered') {
            $output = $this->output->fetch();

            return $this->cleanOutput($output);
        }
    }

    public function removeComments(string $code): string
    {
        $tokens = token_get_all("<?php\n" . $code . '?>');

        return array_reduce($tokens, function ($carry, $token) {
            if (is_string($token)) {
                return $carry . $token;
            }

            $text = $this->ignoreCommentsAndPhpTags($token);

            return $carry . $text;
        }, '');
    }

    protected function ignoreCommentsAndPhpTags($token)
    {
        [$id, $text] = $token;

        if ($id === T_COMMENT) {
            return '';
        }
        if ($id === T_DOC_COMMENT) {
            return '';
        }
        if ($id === T_OPEN_TAG) {
            return '';
        }
        if ($id === T_CLOSE_TAG) {
            return '';
        }

        return $text;
    }

    protected function cleanOutput($output): string
    {
        $output = preg_replace('/(?s)(<aside.*?<\/aside>)|Exit: {2}Ctrl\+D/ms', '$2', $output);

        return trim($output);
    }
}