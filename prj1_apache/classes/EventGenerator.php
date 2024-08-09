<?php
//This class is used to retrieve events from database.
//Generate function is the same as get events, just modified so it fits with the object
class EventGenerator
{

    public function generate($date = NULL, $category = NULL, $limit = 10):EventHolder
    {
        $events = new EventHolder();
        global $db;
        $extra_query = null;
        $stmt = null;
        $both_available = isset($date) && isset($category);
        if($both_available){
            $extra_query = "WHERE event_date = :event_date AND category = :category LIMIT :limit";
        }else if(isset($date)){
            $extra_query = "WHERE event_date = :event_date LIMIT :limit";
        }else if (isset($category)){
            $extra_query = "WHERE category = :category LIMIT :limit";
        }


        if(isset($extra_query)){
            $stmt = $db->prepare('SELECT * FROM events ' . $extra_query);
            if(isset($date)){
                $stmt->execute(['event_date' => "'".strip_tags($date)."'", 'limit' => $limit]);
            }elseif (isset($category)){
                $stmt->execute(['category' => strip_tags($category), 'limit' => $limit]);
            }else{
                $stmt->execute(['event_date' => strip_tags($date), 'category' => strip_tags($category), 'limit' => $limit]);
            }
        }else{
            $stmt = $db->prepare('SELECT * FROM events LIMIT :limit');
            $stmt->execute(['limit' => $limit]);
        }
        //pg_fetch_object ( resource $result [, int $row [, int $result_type = PGSQL_ASSOC ]] ) : object

        foreach ($stmt as $event) {
            $events->setEvents(new Event(
                $event['eventID'],
                $event['name'],
                $event['description'],
                $event['location'],
                $event['event_date'],
                $event['category'],
                $event['amount_tickets'],
                $event['starting_time'],
                $event['uploader_id']
            ));
        }
    }
}