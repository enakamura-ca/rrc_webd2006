<?php

class Site
{
    private $siteActive;

    /**
     * Get the value of siteActive
     */ 
    public function getSiteActive()
    {
        return $this->siteActive;
    }

    /**
     * Set the value of siteActive
     *
     * @return  self
     */ 
    public function setSiteActive($siteActive)
    {
        $this->siteActive = $siteActive;

        return $this;
    }

    public function __construct() {
        $test = null;
    }

    public function ActivateDeactivate($db, $siteActive) {
        $query  = "UPDATE config SET siteActive = :siteActive";
        $statement = $db->prepare($query);

        $bind_values = ['siteActive' => $siteActive];

        $statement->execute($bind_values);

        return true;
    }

    public function checkSiteActive($db) {
        $query  = "SELECT * FROM config";
        $statement = $db->prepare($query);

        $statement->execute();
        $rowcount = $statement->rowCount(); 
        if ($rowcount > 0)
        {
            $record = $statement->fetch();
            return $record['siteActive'];
        }
        else
            return "N";
    }
}

?>