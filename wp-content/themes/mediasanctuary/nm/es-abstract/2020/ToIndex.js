'use strict';

var GetIntrinsic = require('get-intrinsic');

var $RangeError = GetIntrinsic('%RangeError%');

var ToInteger = require('./ToInteger');
var ToLength = require('./ToLength');
var SameValue = require('./SameValue');

// https://ecma-international.org/ecma-262/12.0/#sec-toindex

module.exports = function ToIndex(value) {
	if (typeof value === 'undefined') {
		return 0;
	}
	var integerIndex = ToInteger(value);
	if (integerIndex < 0) {
		throw new $RangeError('index must be >= 0');
	}
	var index = ToLength(integerIndex);
	if (!SameValue(integerIndex, index)) {
		throw new $RangeError('index must be >= 0 and < 2 ** 53 - 1');
	}
	return index;
};
