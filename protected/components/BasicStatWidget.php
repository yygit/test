<?php
/**
 * BasicStatWidget
 * usage examples:
 * $this->widget('application.components.BasicStatWidget', array('option' => 'timestamp')); // for date/time
 * $this->widget('application.components.BasicStatWidget', array('option' => array('users', 'projects', 'myprojects', 'issues', 'myissues'))); // pass option as an array for stats
 */
class BasicStatWidget extends CWidget{
    private $_stat = null;
    public $option = 'date';
    private $allowedStatOptions = array('users', 'projects', 'myprojects', 'issues', 'myissues');

    public function init() {
        $option = $this->option;
        if (empty($option) OR !is_array($option))
            return true;
        elseif (array_diff($option, $this->allowedStatOptions)) // should be empty
            throw new CException('Bad option array element found');
        else {
            $this->_stat = new CMap;
            foreach ($option as $o) {
                $func = '_' . $o;
                $r = $this->$func();
                $this->_stat->add($o, $r);
            }
        }
    }

    /**
     * @return null|CMap
     */
    public function getData() {
        return $this->_stat;
    }

    /**
     * this method is called by CController::endWidget()
     */
    public function run() {
        if ($this->option == 'date')
            $this->render('basicStatWidgetDate');
        elseif ($this->option == 'timestamp')
            $this->render('basicStatWidgetTimestamp');
        elseif (!empty($this->_stat))
            $this->render('basicStatWidgetStat');
    }

    /**
     * @return mixed
     */
    private function _users() {
        $sql = "SELECT COUNT(*) FROM " . User::tableName();
        $command = Yii::app()->db->createCommand($sql);
        $r = $command->queryScalar();
        return $r;
    }

    private function _projects() {
        $sql = "SELECT COUNT(*) FROM " . Project::tableName();
        $command = Yii::app()->db->createCommand($sql);
        $r = $command->queryScalar();
        return $r;
    }

    private function _myprojects() {
        $sql = "SELECT COUNT(*) FROM " . Project::tableName() . " t JOIN " . ProjectUserAssignment::tableName() . " t1 ON t.id=t1.project_id AND t1.user_id=:userId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":userId", Yii::app()->user->id, PDO::PARAM_INT);
        $r = $command->queryScalar();
        return $r;
    }

    private function _issues() {
        $sql = "SELECT COUNT(*) FROM " . Issue::tableName();
        $command = Yii::app()->db->createCommand($sql);
        $r = $command->queryScalar();
        return $r;
    }

    private function _myissues() {
        $sql = "SELECT COUNT(*) FROM " . Issue::tableName() . " t WHERE t.owner_id=:userId";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":userId", Yii::app()->user->id, PDO::PARAM_INT);
        $r = $command->queryScalar();
        return $r;
    }
}
