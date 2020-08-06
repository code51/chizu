var Chizu = function(profile) {
  this.persist = function(kanji, story) {
    var apis = function(method, url, params) {
      params = params ? params : {};

      return window.fetch('http://localhost:9000/apis/' + profile + url, {
        method: method,
        body: method != 'GET' ? JSON.stringify(params) : null,
        headers: {
          'Content-Type': 'application/json'
        }
      }).then(res => res.text());
        // .then(res => res.json()).then(res => res.data ? res.data : null);
    };

    apis('POST', '/kanjis/' + kanji, {
      story: story ? story : null
    });
  };
};