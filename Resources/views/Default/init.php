<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init(<?php echo json_encode(array(
      'appId'  => $app_id,
      'status' => $status, // check login status
      'cookie' => $cookie, // enable cookies to allow the server to access the session
      'xfbml'  => $xfbml,  // parse XFBML
    )) ?>);
  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + <?php echo json_encode('//connect.facebook.net/' . $culture . '/all.js') ?>;
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  })();
</script>
