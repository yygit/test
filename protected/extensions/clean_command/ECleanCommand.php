<?php
class ECleanCommand extends CConsoleCommand{
    public $webRoot;

    public function actionCache() {
        $cache = Yii::app()->getComponent('cache');
        if ($cache !== null) {
            $cache->flush();
            echo "Done.\n";
        } else {
            echo "Error! Please configure cache component.\n";
        }
    }

    public function actionAssets() {
        if (empty($this->webRoot)) {
            echo "Please specify a path to webRoot in command properties.\n";
            Yii::app()->end();
        }

        $this->cleanDir($this->webRoot . '/assets');

        echo "Done.\n";
    }

    public function actionRuntime() {
        $this->cleanDir(Yii::app()->getRuntimePath());
        echo "Done.\n";
    }

    private function cleanDir($dir) {
        $di = new DirectoryIterator ($dir);
        foreach ($di as $d) {
            if (!$d->isDot()) {
                echo "Removed " . $d->getPathname() . "\n";
                $this->removeDirRecursive($d->getPathname());
            }
        }
    }

    private function removeDirRecursive($dir) {
        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file))
                $this->removeDirRecursive($file);
            else {
                if (!preg_match('|\.gitignore$|is', $file))
                    unlink($file);
            }
        }
        if (is_dir($dir))
            rmdir($dir);
    }
}

