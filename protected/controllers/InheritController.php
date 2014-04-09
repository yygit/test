<?php
/**
 * yii-application-cookbook-2nd-edition-code-master\06\implementing_single_table_inheritance
 * Class InheritController
 */
class InheritController extends CController{
    public function actionIndex() {
        $outputString = '';

        if (Yii::app()->user->hasFlash('delete_' . $this->getRoute())) {
            $outputString .= '<div class="flash-success">' . Yii::app()->user->getFlash('delete_' . $this->getRoute()) . '</div>';
        }

        $outputString .=  "<br><h1>All cars</h1>";
        $cars = Car::model()->findAll();
        foreach ($cars as $car) {
            // Each car can be of class Car, SportCar or FamilyCar
            $outputString .=  $car->id . ') ' . get_class($car) . ' ' . $car->name . ' (' . $car->type . ")<br />";
        }

        $outputString .=  "<br><h1>Sport cars only</h1>";
        $sportCars = SportCar::model()->findAll();
        foreach ($sportCars as $car) {
            // Each car should be SportCar
            $outputString .=  get_class($car) . ' ' . $car->name . "<br />";
        }

        $outputString .=  "<br><h1>Family cars only</h1>";
        $sportCars = FamilyCar::model()->findAll();
        foreach ($sportCars as $car) {
            // Each car should be SportCar
            $outputString .=  get_class($car) . ' ' . $car->name . "<br />";
        }

        $this->renderText($outputString);
    }

    protected function afterAction($action) {
        parent::afterAction($action);
        $time = sprintf('%0.5f', Yii::getLogger()->getExecutionTime());
        $memory = round(memory_get_peak_usage() / (1024 * 1024), 2) . " mB";
        echo "\n<br><h3>Time: $time sec; Memory: $memory </h3> \n<br>";
    }

}
