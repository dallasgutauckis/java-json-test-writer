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
              <div class="span4">
                <h3>Variable name</h3>
                <input type="text" name="variable" value="<?php if ( isset( $_POST['variable'] ) ) { echo $_POST['variable']; } ?>"/>
              </div>
              <div class="span10">
                <h3>Convert underscore to lowerCamelCase?</h3>
                <input type="checkbox" name="ucWords" value="yeah" />
              </div>
            </div>
            <div class="row">
              <div class="span10">
                <h3>JSON</h3>
                <textarea rows="20" class="span10" name="input"><?php if ( isset( $_POST['input'] ) ) { echo $_POST['input']; } ?></textarea>
              </div>
            </div>
            <div class="actions">
              <input type="submit" name="submit" class="btn primary" value="Build" />
            </div>
          </fieldset>
        </form>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- java-json-test-writer header -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-7874761747975813"
             data-ad-slot="9345280686"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
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
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-401905-9', 'auto');
      ga('send', 'pageview');

    </script>
  </body>
</html>
