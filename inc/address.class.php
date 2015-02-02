<?php

require '../inc/model.class.php';

class Address extends Model

{
    public $attributes = [];
	
    public function insert()
    {
        $stmt = $this->$dbc->prepare('INSERT INTO address (street, apt, city, state, zip, plus_four, person_id)
                                      VALUES (:street, :apt, :city, :state, :zip, :plus_four, :person_id)');
        $stmt->bindValue(':street', $this->attributes['street'], PDO::PARAM_STR);
        $stmt->bindValue(':apt', $this->attributes['apt'], PDO::PARAM_STR);
        $stmt->bindValue(':city', $this->attributes['city'], PDO::PARAM_STR);
        $stmt->bindValue(':state', $this->attributes['state'], PDO::PARAM_STR);
        $stmt->bindValue(':zip', $this->attributes['zip'], PDO::PARAM_STR);
        $stmt->bindValue(':plus_four', $this->attributes['plus_four'], PDO::PARAM_STR);
        $stmt->bindValue(':person_id', $this->attributes['person_id'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function update()
    {
        $stmt = $this->dbc->prepare('UPDATE address 
                                     SET street = :street, apt = :apt, city = :city, state = :state, zip = :zip, plus_four = :plus_four
                                     WHERE id = :id');
        $stmt->bindValue(':street', $this->attributes['street'], PDO::PARAM_STR);
        $stmt->bindValue(':apt', $this->attributes['apt'], PDO::PARAM_STR);
        $stmt->bindValue(':city', $this->attributes['city'], PDO::PARAM_STR);
        $stmt->bindValue(':state', $this->attributes['state'], PDO::PARAM_STR);
        $stmt->bindValue(':zip', $this->attributes['zip'], PDO::PARAM_STR);
        $stmt->bindValue(':plus_four', $this->attributes['plus_four'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->attributes['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete()
    {
        $stmt = $this->dbc->prepare('DELETE FROM address
                                     WHERE id = :id');
        $stmt->bindValue(':id', $this->attributes['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function find($id, $dbc)
    {
        
        $stmt = $dbc->prepare('SELECT id, street, apt, city, state, zip, plus_four, person_id 
                               FROM address 
                               WHERE id= :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $address_row = $stmt->fetch(PDO::FETCH_OBJ);
    }
}