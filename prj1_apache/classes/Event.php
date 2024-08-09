<?php


class Event
{
    private $eventID;
    private $name;
    private $description;
    private $location;
    private $date;
    private $category;
    private $ticketAmount;
    private $startingTime;
    private $organiserID;


    public function __construct($eventID,$name,$description,$location,$date,$category,$ticketAmount,$startingTime,$organizerID)
    {
        $this->eventID = $eventID;
        $this->name = $name;
        $this->description = $description;
        $this->location= $location;
        $this->date = $date;
        $this->category = $category;
        $this->ticketAmount = $ticketAmount;
        $this->startingTime = $startingTime;
        $this->organiserID = $organizerID;
    }

    public function getEventID(): int
    {
        return $this->eventID;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getTickets(): int
    {
        return $this->ticketAmount;
    }

    public function getStartingTime()
    {
        return $this->startingTime;
    }

    public function getOrganiser()
    {
        return $this->organiserID;
    }
}