<?
class ConsoleApp {
  public static function getScreenSize() {
    preg_match_all("/rows.([0-9]+);.columns.([0-9]+);/", strtolower(exec("stty -a | grep columns")), $output);
    if (sizeof($output) == 3) {
      return array(
        "width"  => $output[1][0],
        "height" => $output[2][0],
      );
    }

    return false;
  }

  public static function clearScreen() {
    ConsoleApp::resetText();

    print chr(27)."[H"; //move cursor to top left
    print chr(27)."[J"; //clear to bottom of screen
  }

  public static function gotoXY($x, $y) {
    $x = ($x == 0) ? 1 : $x;
    $y = ($y == 0) ? 1 : $y;

    //Tem que mover a linha (Y) primeiro pois ao mandar para a linha Y, devolver o cursor para a coluna 1
    if ($y > 0) {
      print chr(27)."[{$y}d";   //move cursor to row Y, first column
    } else {
      $y = abs($y);
      print chr(27)."[300B";    //move cursor down Y rows
      print chr(27)."[{$y}A";   //move cursor up Y rows
    }

    if ($x > 0) {
      print chr(27)."[{$x}G";   //move cursor to column #x
    } else {
      $x = abs($x);
      print chr(27)."[300C";    //move X to rigth
      print chr(27)."[{$x}D";   //move X to left
    }
  }

  public static function printXY($x, $y, $str) {
    //getScreenSize parece ser meio lento. Usar com moderação
    // $scr = ConsoleApp::getScreenSize();

    //Ajuste para tamanho <= 0
    // $maxLen = max(1, $scr["width"] -$x);

    $maxLen = 200;

    ConsoleApp::gotoXY($x, $y);
    print substr($str, 0, $maxLen);
  }

  // print chr(27)."[45m"; //4-Background, 5-magenta

  // print chr(27)."[4m"; //Underlined
  // print chr(27)."[3m"; //Italic - Não
  // print chr(27)."[7m"; //reverse video on
  // print chr(27)."[1m"; //bold text on
  // print chr(27)."[5m"; //blinking text on - Não


  public static function fgColorCode($colorName) {
    if     (!$colorName                 ) {return "0;37";}
    elseif ($colorName == "dark_gray"   ) {return "1;30";}
    elseif ($colorName == "blue"        ) {return "0;34";}
    elseif ($colorName == "light_blue"  ) {return "1;34";}
    elseif ($colorName == "green"       ) {return "0;32";}
    elseif ($colorName == "light_green" ) {return "1;32";}
    elseif ($colorName == "cyan"        ) {return "0;36";}
    elseif ($colorName == "light_cyan"  ) {return "1;36";}
    elseif ($colorName == "red"         ) {return "0;31";}
    elseif ($colorName == "light_red"   ) {return "1;31";}
    elseif ($colorName == "purple"      ) {return "0;35";}
    elseif ($colorName == "light_purple") {return "1;35";}
    elseif ($colorName == "brown"       ) {return "0;33";}
    elseif ($colorName == "yellow"      ) {return "1;33";}
    elseif ($colorName == "light_gray"  ) {return "0;37";}
    elseif ($colorName == "black"       ) {return "0;30";}
    elseif ($colorName == "white"       ) {return "1;37";}
    else                                  {return "0;37";}
  }

  public static function bgColorCode($colorName) {
    if     (!$colorName                 ) {return "40";}
    elseif ($colorName == "black"       ) {return "40";}
    elseif ($colorName == "red"         ) {return "41";}
    elseif ($colorName == "green"       ) {return "42";}
    elseif ($colorName == "yellow"      ) {return "43";}
    elseif ($colorName == "blue"        ) {return "44";}
    elseif ($colorName == "magenta"     ) {return "45";}
    elseif ($colorName == "cyan"        ) {return "46";}
    elseif ($colorName == "light_gray"  ) {return "47";}
    else                                  {return "40";}
  }

  public static function setColor($fg, $bg = null) {
    print chr(27)."[".ConsoleApp::fgColorCode($fg)."m";
    if ($bg != null) {
      print chr(27)."[".ConsoleApp::bgColorCode($bg)."m";
    }
  }

  public static function resetText() {
    print chr(27)."(B".chr(27)."[m"; //reset text attributes
  }
}
?>