<?php

/**
 * PHP item based filtering
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * @package   PHP item based filtering
 */

class Recommend {

    
    public function similarityDistance($preferences, $person1, $person2)
    {
        $similar = array();
        $sum = 0;
        //echo $person1.$person2;
        if (is_array($preferences[$person1]) || is_object($preferences[$person1]))
        {
            foreach($preferences[$person1] as $key=>$value)
            {
                if(array_key_exists($key, $preferences[$person2]))
                    $similar[$key] = 1;
            }
        }
        //print_r($similar);
        if(count($similar) == 0)
            return 0;
        
        foreach($preferences[$person1] as $key=>$value)
        {
            if(array_key_exists($key, $preferences[$person2]))
                $sum = $sum + pow($value - $preferences[$person2][$key], 2);
        }
        
        return  1/(1 + sqrt($sum));     
    }
    
    
    public function matchItems($preferences, $person)
    {
        $score = array();
        
            foreach($preferences as $otherPerson=>$values)
            {
                if($otherPerson !== $person)
                {
                    $sim = $this->similarityDistance($preferences, $person, $otherPerson);
                    
                    if($sim > 0)
                        $score[$otherPerson] = $sim;
                }
            }

        array_multisort($score, SORT_DESC);
        return $score;
    
    }
    
    
    public function transformPreferences($preferences)
    {
        $result = array();
        if (is_array($preferences) || is_object($preferences))
        {
        foreach($preferences as $otherPerson => $values)
        {
            foreach($values as $key => $value)
            {
                $result[$key][$otherPerson] = $value;
            }
        }
    }
    //print_r($result);
        return $result;
    }
    
    
    public function getRecommendations($preferences, $person)
    {
        $total = array();
        $simSums = array();
        $ranks = array();
        $id = array();
        $sim = 0;

        foreach($preferences as $otherPerson=>$values)
        {
            if($otherPerson != $person)
            {
                $sim = $this->similarityDistance($preferences, $person, $otherPerson);
            }
            //echo "[".$person."-".$otherPerson."]  =>";
            //echo  sprintf("%.2f", $sim * 100) . "%<br><br>";
            if($sim > 0)
            {
                foreach($preferences[$otherPerson] as $key=>$value)
                {
                    if(!array_key_exists($key, $preferences[$person]))
                    {
                        if(!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }
                        $total[$key] += $preferences[$otherPerson][$key] * $sim;
                        
                        if(!array_key_exists($key, $simSums)) {
                            $simSums[$key] = 0;
                        }
                        $simSums[$key] += $sim;
                    }
                }
                
            }
        }
        //print_r($total);  
        foreach($total as $key=>$value)
        {
            $ranks[$key] = $value / $simSums[$key];
        }   
        array_multisort($ranks, SORT_DESC);  
        //print_r($ranks);
        return $ranks;    
    }


    public function getIdRecommendations($preferences, $person)
    {
        $total = array();
        $simSums = array();
        $ranks = array();
        $id = array();
        $sim = 0;
        //print_r($preferences);

        foreach($preferences as $otherPerson=>$values)
        {
            if($otherPerson != $person)
            {
                $sim = $this->similarityDistance($preferences, $person, $otherPerson);
            }
            //echo $sim;
            //echo "[".$person."-".$otherPerson."]  =>";
            //echo  sprintf("%.2f", $sim * 100) . "%<br><br>";
            if($sim > 0)
            {
                foreach($preferences[$otherPerson] as $key=>$value)
                {
                    if(!array_key_exists($key, $preferences[$person]))
                    {
                        if(!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }
                        $total[$key] += $preferences[$otherPerson][$key] * $sim;
                        
                        if(!array_key_exists($key, $simSums)) {
                            $simSums[$key] = 0;
                        }
                        $simSums[$key] += $sim;
                    }
                }
                
            }
        }
        foreach($total as $key=>$value)
        {
            array_push($id,$key);
        }
    return $id;
        
    }
   
}

?> 