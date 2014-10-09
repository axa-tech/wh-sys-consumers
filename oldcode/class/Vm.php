<?php
/**
 Class VM
 description class vm 
*/
//'{"type":"WAP","name":"LAMPAUTO","networks":"NTRlNjhlOWQtMGZmYi00ZjlhLTk3ZjktNWY4OGVkYTRiNDdlLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==","flavor":"NDA5Ni8y","image":"MzA4OTJmNDItMWJhZi00MWZkLTg5MTItMDY1OWIwYTBmNTljLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==","adminPass":"password","environmentId":"MWJlODdhZDQtNWUxYi00OTZmLTg1NTYtNjg2NWYxNzcxYWU1LzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA==","subnetId":"MzdkNTAyMmUtYjkyMi00ODA3LTkyYmEtMzNhYTcwZGFkM2RkLzJmZjQ1ZmJkLTQyODktNGE1Zi1hZjYyLWMxY2M4YTIwNTRjNA=="}'
class Vm {
    var $id;
    var $adminpass;
    var $sshkey;
    var $type;
    var $name;
    var $flavor;
    var $image;
    /**
     * @return the $adminpass
     */
    public function getAdminpass()
    {
        return $this->adminpass;
    }

	/**
     * @return the $sshkey
     */
    public function getSshkey()
    {
        return $this->sshkey;
    }

	/**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $flavor
     */
    public function getFlavor()
    {
        return $this->flavor;
    }

	/**
     * @return the $image
     */
    public function getImage()
    {
        return $this->image;
    }

	/**
     * @param field_type $sshkey
     */
    public function setSshkey($sshkey)
    {
        $this->sshkey = $sshkey;
    }

	/**
     * @param field_type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param field_type $flavor
     */
    public function setFlavor($flavor)
    {
        $this->flavor = $flavor;
    }

	/**
     * @param field_type $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    /**
     * @param unknown $type
     * @param unknown $name
     * @param unknown $flavor
     * @param unknown $image
     */
	function __construct($type,$name,$flavor,$image){
        $this->type=$type;
        $this->name=$name;
        $this->flavor=$flavor;
        $this->image=$image;
    }
}

?>
