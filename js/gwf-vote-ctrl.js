"use strict";
angular.module('gdo6').
controller('GDOVoteCtrl', function($scope, GWFRequestSrvc) {
	$scope.voteInit = function(config) {
		console.log('GWFVoteCtrl.voteInit()', config);
		$scope.rating = config.own_vote;
		$scope.count = config.count;
		$scope.voteurl = config.voteurl;
	};
	$scope.onVote = function(vote) {
		console.log('GWFVoteCtrl.onVote()', vote);
		var url = $scope.voteurl + "&ajax=1&fmt=json&rate="+vote;
		GWFRequestSrvc.send(url).then($scope.onVoted);
	};
	
	$scope.onVoted = function(result) {
		console.log('GWFVoteCtrl.onVoted()', result);
	};
});
