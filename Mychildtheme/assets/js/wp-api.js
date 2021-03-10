options.beforeSend = function(xhr) {
    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
 
    if (beforeSend) {
        return beforeSend.apply(this, arguments);
    }
};

$.ajax( {
    url: wpApiSettings.root + 'wp/v2/posts/1',
    method: 'POST',
    beforeSend: function ( xhr ) {
        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
    },
    data:{
        'title' : 'Hello Moon'
    }
} ).done( function ( response ) {
    console.log( response );
} );