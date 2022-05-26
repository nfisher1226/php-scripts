<?php
$th= <<< EOF
    <table>
      <caption>CAPTION</caption>
      <tr>
        <th>Fret</th><th>Length</th><th>From Nut</th><th>From Bridge</th>
      </tr>

EOF;

class Fretboard {
  public $scale;
  public $frets;

  public function __construct($scale = 25, $frets = 24) {
    $this->scale = $scale;
    $this->frets = $frets;
  }

  public function display() {
    return "    <p>".$this->scale." inch scale with ".$this->frets." frets</p>\n";
  }

  public function frets() {
    global $th;
    echo str_replace("CAPTION",$this->display(),$th);
    $scale = $this->scale;
    for ($p = 1; $p <= $this->frets; $p++) {
      $fret = $scale - ($this->scale / pow(2.0, $p / 12.0));
      $scale -= $fret;
      echo "      <tr>\n        <th scope=\"row\">" . $p . "</th><td>" . number_format($fret, 4) .
        "</td><td>" . number_format($this->scale - $scale, 4) ."</td><td>" . number_format($scale, 4) .
        "</td>\n      </tr>\n";
    }
    echo "    </td>\n  </table>\n";
  }
}

$scale = 25;
$frets = 24;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (is_numeric($_POST["scale"])) {
    $scale = $_POST["scale"];
  } else {
    $scale = 25.5;
  }
  if (is_numeric($_POST["frets"])) {
    $frets = $_POST["frets"];
  } else {
    $frets = 24;
  }
}
?>
<!Doctype html>
<html>
  <head>
    <style>
      body {
        margin: 50px;
      }

      table {
        border-collapse: collapse;
        border: 2px solid rgb(200,200,200);
        letter-spacing: 1px;
        font-size: 0.8rem;
      }

      table {
        border-collapse: collapse;
        border: 2px solid rgb(200,200,200);
        letter-spacing: 1px;
        font-size: 0.8rem;
      }

      td, th {
        border: 1px solid rgb(190,187,192);
        padding: 6px 25px;
      }

      th {
        background-color: rgb(235,232,237);
      }

      td {
        text-align: center;
      }

      tr:nth-child(even) td {
        background-color: rgb(250,247,252);
      }

      tr:nth-child(odd) td {
        background-color: rgb(245,242,247);
      }

      caption {
        padding: 10px;
      }

      input {
        border-color: rgb(155,152,157);
        border-radius: 6px;
      }
    </style>
  </head>
  <body>
    <h1>Fret scale calculator</h1>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	Scale Length: <input type="number" name="scale" placeholder="Scale Length" min=11.0 max=42.0
          step=0.0125 required value="<?php echo $scale;?>">
        <span class="error">* <?php echo $nameErr;?></span>
        Frets: <input type="number" name="frets" placeholder="Frets" min=8 max=30 step=1 required
          value="<?php echo $frets;?>">
        <input type="submit" name="submit" value="Submit">
      </form>
<?php
$fretboard = new Fretboard($scale, $frets);
$fretboard -> frets();
?>
  </body>
</html>
