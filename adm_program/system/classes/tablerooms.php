<?php
/******************************************************************************
 * Class manages access to database table adm_rooms
 *
 * Copyright    : (c) 2004 - 2015 The Admidio Team
 * Homepage     : http://www.admidio.org
 * License      : GNU Public License 2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Diese Klasse dient dazu, um ein neues Raumobjekt in der Datenbanktabelle
 * adm_rooms zu erstellen.
 *
 *****************************************************************************/

/**
 * Class TableRooms
 */
class TableRooms extends TableAccess
{
    /**
     *  Constructor that will create an object of a recordset of the table adm_rooms.
     *  If the id is set than the specific room will be loaded.
     *  @param object $databaseObject Object of the class Database. This should be the default global object @b $gDb.
     *  @param int    $room_id        The recordset of the room with this id will be loaded. If id isn't set than an empty object of the table is created.
     */
    public function __construct(&$databaseObject, $room_id = 0)
    {
        parent::__construct($databaseObject, TBL_ROOMS, 'room', $room_id);
    }

    /**
     * Get the value of a column of the database table.
     * If the value was manipulated before with @b setValue than the manipulated value is returned.
     * @param string $columnName The name of the database column whose value should be read
     * @param string $format     For date or timestamp columns the format should be the date/time format e.g. @b d.m.Y = '02.04.2011'. @n
     *                           For text columns the format can be @b database that would return the original database value without any transformations
     * @return mixed Returns the value of the database column.
     *               If the value was manipulated before with @b setValue than the manipulated value is returned.
     */
    public function getValue($columnName, $format = '')
    {
        if($columnName === 'room_description')
        {
            if(isset($this->dbColumns['room_description']) === false)
            {
                $value = '';
            }
            elseif($format === 'database')
            {
                $value = html_entity_decode(strStripTags($this->dbColumns['room_description']));
            }
            else
            {
                $value = $this->dbColumns['room_description'];
            }
        }
        else
        {
            $value = parent::getValue($columnName, $format);
        }

        return $value;
    }

    /**
     * Set a new value for a column of the database table.
     * The value is only saved in the object. You must call the method @b save to store the new value to the database
     * @param  string $columnName The name of the database column whose value should get a new value
     * @param  mixed  $newValue   The new value that should be stored in the database field
     * @param  bool   $checkValue The value will be checked if it's valid. If set to @b false than the value will not be checked.
     * @return bool   Returns @b true if the value is stored in the current object and @b false if a check failed
     */
    public function setValue($columnName, $newValue, $checkValue = true)
    {
        if($columnName === 'room_description')
        {
            return parent::setValue($columnName, $newValue, false);
        }
        return parent::setValue($columnName, $newValue, $checkValue);
    }
}
?>
