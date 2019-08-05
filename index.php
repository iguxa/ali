<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

Interface SubwayStrategy{
    public function getIn(Ride $ride);
    public function getOut();
}

abstract class Ride{
    static private $_cost = 30;
    static private $_exeption = ['insufficient'=>'Не достаточно средств'];

    private $ride;
    public $wallet;

    public function __construct(Wallet $wallet, SubwayStrategy $ride)
    {
        $this->ride = $ride;
        $this->wallet = $wallet;
        $this->init();
    }

    public function init(): void
    {
        $money = $this->wallet->getMoney();
        try {
            if($money<self::$_cost and $money!=self::$_cost){
                throw new Exception(self::$_exeption['insufficient'].' - '.$money);
            }
        }catch (Exception $e){
                die($e->getMessage());
        }
    }
    public function getTicket(): void
    {
        $money = $this->wallet->getMoney();
        $result = $money - self::$_cost;
        try{
            if($result>=0){
                $this->wallet->setMoney($result);
            }else{
                throw new Exception(self::$_exeption['insufficient'].' - '.$money);
            }
        }catch (Exception $e){
            die($e->getMessage());
        }

    }
    public function getIn()
    {
        $this->ride->getIn($this);
        return $this;
    }
    public function getOut()
    {
        try{
            $exit = $this->ride->getOut();
        }catch (Exception $e){
            die($e->getMessage());
        }
        return $exit;
    }
}


class SingleSubway implements SubwayStrategy{
    public function getIn(Ride $ride): void
    {
        $ride->getTicket();
    }
    public function getOut()
    {
        throw new Exception('На данной станции турникет работает на вход');
    }
}

class DoubleSubway implements SubwayStrategy{
    public function getIn(Ride $ride): void
    {
        $ride->getTicket();
    }
    public function getOut()
    {
        return 'Счастливого пути';
    }
}

class Wallet {
    private $money;

    public function __construct(int $money)
    {
        $this->setMoney($money);
    }

    /**
     * @return mixed
     */
    public function getMoney(): int
    {
        return $this->money;
    }

    /**
     * @param mixed $money
     */
    public function setMoney($money): void
    {
        $this->money = $money;
    }
}


class Person extends Ride {
}
$single = new Person(new Wallet(30),new SingleSubway());
var_dump($single->getIn()/*->getOut()*/);

$duble = new Person(new Wallet(30),new DoubleSubway());
var_dump($duble->getIn()->getOut());
