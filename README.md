Stream_Filter_Endofline
=======================

PHPストリームのカスタムフィルタ。

例：改行コードを変換しながらCSVファイルを読み込む。

    <?php
    require 'Stream/Filter/Endofline.php';

    $fp = fopen('/path/to/file', 'r');
    $ret = stream_filter_register("eol.*", "Stream_Filter_Endofline");
    $filter = stream_filter_append($fp,
      'eol.CRLF:LF', // CRLF -> LFに変換
      // 'eol.CR', // CR -> PHP_EOLに変換
      STREAM_FILTER_READ
    );

    while(($data = fgetcsv($fp)) !== false) {
      // print_r($data);
    }

    fclose($fp);
