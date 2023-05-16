<?php

$pid=array();
$pname=[];
$pvalue=[];

readfromfile($pid,$pname,$pvalue);

function writetofile($pid,$pname,$pvalue)
{
    $fp = fopen("contents.txt","w");
    fwrite($fp,implode(",",$pid));
    fwrite($fp,"\n");
    fwrite($fp,implode(",",$pname));
    fwrite($fp,"\n");
    fwrite($fp,implode(",",$pvalue));
}

function readfromfile(&$pid,&$pname,&$pvalue)
{
     $fp = fopen("contents.txt","r");
     $i=0;
     while(!feof($fp))
     {  
         $line = fgets($fp);
        if(strlen($line)>0)
        {
        if($i==0)
        {
            $pid=explode(",",$line);
            $pid[2] = substr($pid[2],0,-1);
        }
        else if($i==1)
        {
            $pname = explode(",",$line);
            $pname[2] = substr($pname[2], 0, -1);
        }
        else if($i==2)
        {
            $pvalue = explode(",",$line);
            $pvalue[2] = substr($pvalue[2],0,-1);
        }
        $i++;
            
        }
     }
}



function update(&$pid, &$pname, &$pvalue){
    $pid_update = (int)readline("enter the product ID to update: ");
    echo "\n1. Update product name\n2. Update product price\n";
    $choice = (int)readline("enter your choice: ");
    for($index=0; $index<count($pid) && $pid[$index] != $pid_update ; $index++);
    switch ($choice) {
        case 1:
            //name
            $pname[$index] = readline("Enter product name to update: ");
            echo "Update success!";
            break;
            
        case 2:
            //price
            $pvalue[$index] = (int)readline("Enter product price to update: ");
            echo "Update success!";
            break;
        
        default:
            echo "Enter a valid choice";
            break;
    }
}

function search(&$pid, &$pname, &$pvalue){
    $pid_search = (int)readline("enter the product ID to search: ");
    for($index=0; $index<count($pid) && $pid[$index] != $pid_search ; $index++);
    //display
    echo "product Id: ".$pid[$index]."\nproduct name: ".$pname[$index]."\nproduct price: ".$pvalue[$index]."\n";
}

function add($prodname,$prodvalue,&$pid,&$pname,&$pvalue){
 $pid_length = count($pid);
 $newpid= 0;
 if($pid_length==0)
 {
 $newpid = 1;
 }
 else{
 $newpid = $pid[$pid_length-1]+1;
 }
 array_push($pid,$newpid);
 array_push($pname,$prodname);
 array_push($pvalue,$prodvalue);
}
function delete_prod($prodid,&$pid, &$pname, &$pvalue)
{
    $index = array_search($prodid,$pid);
    array_splice($pid,$index,1);
    array_splice($pname,$index,1);
    array_splice($pvalue,$index,1);
}

function display(&$pid, &$pname, &$pvalue)
{
    $header = sprintf("%s %s %s",str_pad("PID",6," ",STR_PAD_RIGHT),str_pad("PNAME",20," ",STR_PAD_RIGHT),str_pad("PVALUE",4," ",STR_PAD_RIGHT));
    echo $header."\n";
    for($i=0;$i<count($pid);$i++)
    {
        
        $result_pid = str_pad($pid[$i],6," ",STR_PAD_RIGHT);
        $result_pname = str_pad($pname[$i],20," ",STR_PAD_RIGHT);
        $result_pvalue = str_pad($pvalue[$i],4," ",STR_PAD_RIGHT);
        $line = sprintf("%s %s %s",$result_pid,$result_pname,$result_pvalue);
        echo $line."\n";
    }
}

$flag = 1;
while($flag){
echo "MENU\n1.Add a product\n2.Update a product\n3.Delete a product\n4.Display all products\n5.Search for a product\n6.Exit\n";
$menu_choice = (int)readline("Enter your choice : ");

switch ($menu_choice) {
    case 1:
        // add
        $name = readline("Enter product name: ");
        $value = readline("Enter product price: ");
        add($name, $value,$pid, $pname, $pvalue);
        break;
        
    case 2:
        // update
        update($pid, $pname, $pvalue);
        break;
    
    case 3:
        // del
        $id = readline("Enter product Id: ");
        delete_prod($id,$pid, $pname, $pvalue);
        break;
    
    case 4:
        // display
        display($pid, $pname, $pvalue);
        break;
    
    case 5:
        // Search
        Search($pid, $pname, $pvalue);
        break;
        
    case 6:
        // exit
        writetofile($pid, $pname, $pvalue);
        $flag = 0;
        break;
    
    default:
        echo "\nEnter a valid choice";
        break;
}

}
