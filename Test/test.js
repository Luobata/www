function checkPassword(username, passwordGuess, callback) {
    var queryStr = 'SELECT * FROM user WHERE username = ?';
    db.query(queryStr, username, function(err, result) {
        if (err) throw err;
        hash(passwordGuess, function(passwordGuessHash) {
            callback(passwordGuessHash === result['password_hash']);
        });
    });
}

function checkPassword(username, passwordGuess, callback) {
    var passwordHash;
    var queryStr = 'SELECT * FROM user WHERE username = ?';
    db.query(qyeryStr, username, queryCallback);

    function queryCallback(err, result) {
        if (err) throw err;
        passwordHash = result['password_hash'];
        hash(passwordGuess, hashCallback);
    }

    function hashCallback(passwordGuessHash) {
        callback(passwordHash === passwordGuessHash);
    }
}


PubSub.on = function(eventType, handler) {
    if (!(eventType in this.handlers)) {
        this.handlers[eventType] = [];
    }
    this.handlers[eventType].push(handler);
    return this;
};


PubSub.emit = function(eventType) {
    var handlerArgs = Array.prototype.slice.call(arguments, 1);
    for (var i = 0; i < this.handlers[eventType].length; i++) {
        this.handlers[eventType][i].apply(this, handlerArgs);
    }
    return this;
};
