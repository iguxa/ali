<?php

Interface RideStrategy{
    public function cost(Ride $ride);
    public function typeRide();
}


abstract class Ride{
    private $miles;
    private $ride;
    public function __construct($miles,RideStrategy $ride)
    {
        $this->miles = $miles;
        $this->ride = $ride;
    }
    public function cost()
    {
        return $this->ride->cost($this);
    }
    public function getMiles()
    {
        return $this->miles;
    }
    public function getRide()
    {
        return $this->ride->typeRide();
    }
}


class Taxi implements RideStrategy{
    public function cost(Ride $ride)
    {
        return $ride->getMiles()*100;
    }
    public function typeRide()
    {
        return 'Такси';
    }
}
class Metro implements RideStrategy{
    public function cost(Ride $ride)
    {
        return $ride->getMiles()*50;
    }
    public function typeRide()
    {
        return 'Метро';
    }
}
class Train implements RideStrategy{
    public function cost(Ride $ride)
    {
        return $ride->getMiles()*80;
    }
    public function typeRide()
    {
        return 'Электричка';
    }
}
class Person extends Ride {
}
$ride = new Person(10,new Taxi());
echo $ride->cost().'<br>';
echo $ride->getRide().'<br>';