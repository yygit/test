<?php
class ECleanCommand extends CConsoleCommand{
    public $webRoot;

    public function getHelp() {
        $out = "Clean command allows you to clean up various temporary data Yii and an application are generating.\n\n";
        return $out . parent::getHelp();
    }

    public function actionAll() {
        $this->actionCache();
        $this->actionAssets();
        $this->actionRuntime();
    }

    /**
     * cleans cache for CConsoleApplication instance app, that is for console app, not web app
     * var_dump(get_class(Yii::app())); // CConsoleApplication
     */
    public function actionCache() {
        $app = Yii::app();
        $appClass = get_class($app);
        $cache = $app->getComponent('cache');
        if ($cache !== null) {
            $cache->flush();
            echo "Done cache for " . $appClass . "\n";
        } else {
            echo "Please configure cache component for " . $appClass . "\n";
        }
    }

    public function actionAssets() {
        if (empty($this->webRoot)) {
            echo "Please specify a path to webRoot in command properties.\n";
            Yii::app()->end();
        }

        $this->cleanDir($this->webRoot . '/assets');

        echo "Done assets.\n";
    }

    public function actionRuntime() {
        $this->cleanDir(Yii::app()->getRuntimePath());
        echo "Done runtime.\n";
    }

    private function cleanDir($dir) {
        $di = new DirectoryIterator($dir);
        foreach ($di as $d) {
            if (!$d->isDot() && !preg_match('|^\..+|i', $d->current())) { // do not remove items beginning with a dot
                echo "Removing " . $d->getPathname() . "\n";
                $this->removeDirRecursive($d->getPathname(), $d->isFile());
            }
        }
    }

    private function removeDirRecursive($dir, $isFile = false) {
        if ($isFile) {
            unlink($dir);
            return;
        }
        $files = glob($dir . DIRECTORY_SEPARATOR . '{,.}*', GLOB_MARK | GLOB_BRACE);
        foreach ($files as $file) {
            if (basename($file) == '.' || basename($file) == '..')
                continue;
            if (substr($file, -1) == DIRECTORY_SEPARATOR)
                $this->removeDirRecursive($file);
            else {
                unlink($file);
            }
        }
        if (is_dir($dir)) {
            rmdir($dir);
        }
    }
}
