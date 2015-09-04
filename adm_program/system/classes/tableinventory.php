<?php
/******************************************************************************
 * Class manages access to database table adm_invent
 *
 * Copyright    : (c) 2004 - 2015 The Admidio Team
 * Homepage     : http://www.admidio.org
 * License      : GNU Public License 2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * this Class is used to create an object from Inventory.
 * an item can be managed from this class
 *
 * Beside the methods of the parent class there are the following additional methods:
 *
 *****************************************************************************/

class TableInventory extends TableAccess
{
    /** Constructor that will create an object of a recordset of the table adm_invent.
     *  If the id is set than the specific item will be loaded.
     *  @param object $databaseObject Object of the class Database. This should be the default global object @b $gDb.
     *  @param int    $itemId         The recordset of the item with this id will be loaded. If id isn't set than an empty object of the table is created.
     */
    public function __construct(&$databaseObject, $itemId = 0)
    {
        parent::__construct($databaseObject, TBL_INVENT, 'inv', $itemId);
    }

    /** Additional to the parent method the item will be set @b valid per default.
     */
    public function clear()
    {
        parent::clear();

        // new item should be valid
        $this->setValue('inv_valid', 1);
        $this->columnsValueChanged = false;
    }

    /** Deletes the selected item of the table and all the many references in other tables.
     *  After that the class will be initialize.
     *  @return @b true if no error occurred
     */
    public function delete()
    {
        $this->db->startTransaction();

        $sql    = 'DELETE FROM '. TBL_INVENT_DATA. ' WHERE ind_itm_id = '. $this->getValue('inv_id');
        $this->db->query($sql);

        $return = parent::delete();

        $this->db->endTransaction();
        return $return;
    }

}
?>
