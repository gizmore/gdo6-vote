"use strict";
angular.module('gdo6').
controller('GDOVoteCtrl', function($scope, GDORequestSrvc) {
	$scope.voteInit = function(config) {
		console.log('GDOVoteCtrl.voteInit()', config);
		$scope.rating = config.own_vote;
		$scope.count = config.count;
		$scope.voteurl = config.voteurl;
	};
	$scope.onVote = function(vote) {
		console.log('GDOVoteCtrl.onVote()', vote);
		var url = $scope.voteurl + "&ajax=1&fmt=json&rate="+vote;
		GDORequestSrvc.send(url).then($scope.onVoted);
	};
	
	$scope.onVoted = function(result) {
		console.log('GDOVoteCtrl.onVoted()', result);
	};
});
