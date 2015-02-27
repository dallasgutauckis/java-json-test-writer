<html>
  <head>
  </head>
  <body>
    <form method="post">
      <label for="variable">Variable name: <input type="text" name="variable" value="<?php if ( isset( $_POST['variable'] ) ) { echo $_POST['variable']; } ?>"/></label><br />
      <label for="input">JSON</label><br />
      <textarea rows="40" cols="120" name="input"><?php if ( isset( $_POST['input'] ) ) { echo $_POST['input']; } ?></textarea><br />
      <input type="submit" />
    </form>
    <pre>
    <?php


      if ( isset( $_POST['input'] ) ) {
        $src = json_decode( $_POST['input'] );
        printAssert( $_POST['variable'], $src );
      }

      function println( $text ) {
        echo "        " . $text. "\r\n";
      }

      function getKeyPathString( $keyPath, $key ) {
        return (count($keyPath) > 0 ? implode( '.', $keyPath ) . '.' : '') . $key;
      }

      function printAssertEquals( $keyPath, $key, $value ) {
        println( 'assertEquals(' . $value . ', ' . getKeyPathString( $keyPath, $key ) . ');' );
      }

      function printAssert( $key, $value, $keyPath = null ) {
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
                printAssert( $itemKey, $itemValue, $keyPath );
              }
              unset( $keyPath[$newIndex] );
              
          }

      }
    ?>
    </pre>
  </body>
</html>
