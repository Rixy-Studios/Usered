<?php
//function stealFromStackOverflow($code){
//    echo $code;
//}
class Utils{
    public function sendMail($mail, $host, $from, $address, $subject, $body){
        //Made by Me :D
        $mail->IsSMTP();
        $mail->Host = $host;
        $mail->From = $from;
        $mail->FromName = 'Usered Bot';
        $mail->AddAddress($address);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'Your email client does not support HTML. Please upgrade to a new one.';
        if(!$mail->Send()){
        }
    }
    public function formatText($text, $htmlspecialcharised){
        if($htmlspecialcharised){
            $text = htmlspecialchars($text);
        }
        $text = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
        $text = nl2br($text);
        return $text;
    }
    public function tokenGen(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
    public function get_time_ago( $time )
    {
        $time_difference = time() - $time;
    
        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );
    
        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;
    
            if( $d >= 1 )
            {
                $t = round( $d );
                return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
    function date_compare($a,$b)
    {
        return strcmp($a['timestamp'],$b['timestamp']);
    }
}