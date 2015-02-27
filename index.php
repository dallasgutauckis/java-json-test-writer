<html>
  <head>
    <title>java-json-test-writer</title>
    <link rel="stylesheet" href="stylesheets/bootstrap.min.css" type="text/css" charset="utf-8" />
  </head>
  <body>
    <a href="https://github.com/dallasgutauckis/java-json-test-writer"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png" alt="Fork me on GitHub"></a>
    <div class="container">
      <div class="content">
        <h1>java-json-test-writer</h1>
        <em>by <a href="http://dallasgutauckis.com">Dallas Gutauckis</a></em>
        <form method="post">
          <fieldset>
            <div class="row">
              <div class="span3">
                <label for="variable">Variable name: <input type="text" name="variable" value="<?php if ( isset( $_POST['variable'] ) ) { echo $_POST['variable']; } ?>"/></label><br />
              </div>
            </div>
            <div class="row">
              <div class="span6">
                <label for="ucWords">Convert underscores to lowerCamelCase? <input type="checkbox" name="ucWords" value="yeah" /></label><br />
              </div>
            </div>
            <div class="row">
              <div class="span10">
                <label for="input">JSON</label><br />
                <textarea rows="20" class="span10" name="input"><?php if ( isset( $_POST['input'] ) ) { echo $_POST['input']; } ?></textarea><br />
              </div>
            </div>
            <div class="actions">
              <input type="submit" name="submit" class="btn primary" value="Build" />
            </div>
          </fieldset>
        </form>
        <pre><?php

          if ( isset( $_POST['input'] ) ) {
            $src = json_decode( $_POST['input'] );
            $ucWords = $_POST['ucWords'] == "yeah";
            printAssert( $_POST['variable'], $src, $ucWords );
          }

          function println( $text ) {
            echo $text. "\r\n";
          }

          function getKeyPathString( $keyPath, $key ) {
            return (count($keyPath) > 0 ? implode( '.', $keyPath ) . '.' : '') . $key;
          }

          function printAssertEquals( $keyPath, $key, $value ) {
            println( 'assertEquals(' . $value . ', ' . getKeyPathString( $keyPath, $key ) . ');' );
          }

          function printAssert( $key, $value, $ucWords, $keyPath = null ) {
              if ( $ucWords ) {
                $key = preg_replace( '/_(.?)/e',"strtoupper('$1')", $key ); 
              }

              if ( $keyPath === null ) {
                $keyPath = array();
              }

              switch ( gettype( $value ) ) {
                case 'NULL':
                  println( 'assertNull(' . getKeyPathString( $keyPath, $key ) . ');' );
                case 'boolean':
                  println( 'assert' . ( $value ? 'True' : 'False' ) . '(' . getKeyPathString( $keyPath, $key ) . ');' );
                  break;
                case 'integer':
                  printAssertEquals( $keyPath, $key, $value );
                  break;
                case 'double':
                  printAssertEquals( $keyPath, $key, $value . 'd' );
                  break;
                case 'string':
                  printAssertEquals( $keyPath, $key, '"' . $value . '"' );
                  break;
                case 'array':
                case 'object':
                  $newIndex = count( $keyPath );
                  $keyPath[$newIndex] = $key;

                  foreach ( $value as $itemKey => $itemValue ) {
                    printAssert( $itemKey, $itemValue, $ucWords, $keyPath );
                  }

                  unset( $keyPath[$newIndex] );
                  
              }

          }
        ?>
        </pre>
      </div>
    </div>
  </body>
</html>
