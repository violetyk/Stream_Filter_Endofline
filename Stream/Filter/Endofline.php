<?php
class Stream_Filter_Endofline extends php_user_filter
{
  var $from;
  var $to;
  var $mapping = array(
    'CRLF' => "\r\n",
    'CR'   => "\r",
    'LF'   => "\n",
  );

  function onCreate() {
    if (preg_match('/^eol\.(\w+)$/', $this->filtername, $matches)) {
      $this->from = $this->mapping[strtoupper($matches[1])];
      $this->to   = PHP_EOL;
      return true;
    } elseif(preg_match('/^eol\.(\w+)\:(\w+)$/', $this->filtername, $matches)) {
      $this->from = $this->mapping[strtoupper($matches[1])];
      $this->to   = $this->mapping[strtoupper($matches[2])];
      return true;
    }

    return false;
  }

  function filter($in, $out, &$consumed, $closing) {
    while ($bucket = stream_bucket_make_writeable($in)) {
      $bucket->data = str_replace($this->from, $this->to, $bucket->data);
      $consumed += $bucket->datalen;
      stream_bucket_append($out, $bucket);
    }
    return PSFS_PASS_ON;
  }
}
