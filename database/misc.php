<?php
class Misc{
    public function getTimestampFromDate($conn, $date){
        $query = $conn->prepare("SELECT UNIX_TIMESTAMP(:date)");
        $query->execute([
            "date" => $date
        ]);
        $tmstp = $query->fetch();
        return $tmstp[0];
    }
}