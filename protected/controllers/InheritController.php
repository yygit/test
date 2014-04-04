<?php
/**
 * yii-application-cookbook-2nd-edition-code-master\06\implementing_single_table_inheritance
 * Class InheritController
 */
class InheritController extends CController{
    public function actionIndex() {
        echo "<h1>All cars</h1>";
        $cars = Car::model()->findAll();
        foreach ($cars as $car) {
            // Each car can be of class Car, SportCar or FamilyCar
            echo get_class($car) . ' ' . $car->name . ' (' . $car->type . ")<br />";
        }

        echo "<h1>Sport cars only</h1>";
        $sportCars = SportCar::model()->findAll();
        foreach ($sportCars as $car) {
            // Each car should be SportCar
            echo get_class($car) . ' ' . $car->name . "<br />";
        }

        echo "<h1>Family cars only</h1>";
        $sportCars = FamilyCar::model()->findAll();
        foreach ($sportCars as $car) {
            // Each car should be SportCar
            echo get_class($car) . ' ' . $car->name . "<br />";
        }
    }

    protected function afterAction($action) {
        parent::afterAction($action);
        $time = sprintf('%0.5f', Yii::getLogger()->getExecutionTime());
        $memory = round(memory_get_peak_usage() / (1024 * 1024), 2) . " mB";
        echo "\n<br><h3>Time: $time sec; Memory: $memory </h3> \n<br>";
    }

}
