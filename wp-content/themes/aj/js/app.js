var myapp = angular.module('myapp', ['ngRoute', 'ngSanitize']);

myapp.config(function($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);

    $routeProvider
            .when('/', {
                templateUrl: aeJS.partials + 'main.html',
                controller: 'main'
            })
            .when('/blog', {
                templateUrl: aeJS.partials + 'blog.html',
                controller: 'blog'
            })
            .when('/portfolio', {
                templateUrl: aeJS.partials + 'portfolio.html',
                controller: 'portfolio'
            })
            .when('/:slug', {
                templateUrl: aeJS.partials + 'content.html',
                controller: 'content'
            })
            .when('/category/:category', {
                templateUrl: aeJS.partials + 'main.html',
                controller: 'category'
            })
            .otherwise({
                redirectTo: '/'
            });
});


// Set the configuration
myapp.run(['$rootScope', function($rootScope) {
        // Variables defined by wp_localize_script
        $rootScope.api = aeJS.api;
    }
]);


myapp.controller('main', ['$scope', '$http', function($scope, $http) {
        $http({
            method: 'GET',
            url: $scope.api + '/posts',
            params: {
                'filter[post_per_page]': 10,
                'type[]': 'page'
            },
        }).
                success(function(data, status, headers, config) {
                    $scope.posts = data;
                    document.querySelector('title').innerHTML = 'Accueil | AngularJS test';
                }).
                error(function(data, status, headers, config) {
                });

        $http({
            method: 'GET',
            url: $scope.api + '/taxonomies/category/terms',
            params: {},
        }).
                success(function(data, status, headers, config) {
                    $scope.categories = data;
                    $scope.pageTitle = 'Latest Posts:';
                }).
                error(function(data, status, headers, config) {
                });
    }]);

myapp.controller('blog', ['$scope', '$http', function($scope, $http) {
        $http({
            method: 'GET',
            url: $scope.api + '/posts',
            params: {
                'filter[post_per_page]': 10,
            },
        }).
                success(function(data, status, headers, config) {
                    $scope.posts = data;
                }).
                error(function(data, status, headers, config) {
                });
    }]);


myapp.controller('content', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
        $http({
            method: 'GET',
            url: $scope.api + '/posts',
            params: {
                'filter[name]': $routeParams.slug,
                'type[0]': 'page',
                'type[1]': 'post',
            },
        }).
                success(function(data, status, headers, config) {
                    $scope.posts = data;
                    document.querySelector('title').innerHTML = data[0].title + ' | AngularJS test';
                }).
                error(function(data, status, headers, config) {
                });
    }]);


myapp.controller('category', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
        $http({
            method: 'GET',
            url: $scope.api + '/taxonomies/category/terms',
            params: {},
        }).
                success(function(data, status, headers, config) {
                    $scope.categories = data;
                    $scope.pageTitle = 'Latest Posts:';
                }).
                error(function(data, status, headers, config) {
                });

        $http({
            method: 'GET',
            url: $scope.api + '/taxonomies/category/terms/' + $routeParams.category,
            params: {},
        }).
                success(function(data, status, headers, config) {
                    $scope.current_category_id = $routeParams.category;
                    $scope.pageTitle = 'Posts in ' + data.name + ':';
                    document.querySelector('title').innerHTML = 'Category: ' + data.name + ' | AngularJS test';

                    $http.get('wp-json/posts/?filter[category_name]=' + data.name).success(function(res) {
                        $scope.posts = res;
                    });
                }).
                error(function(data, status, headers, config) {
                });
    }]);


myapp.controller('portfolio', ['$scope', '$http', function($scope, $http) {
        $http({
            method: 'GET',
            url: $scope.api + '/posts',
            params: {
                'filter[post_per_page]': -1,
                'type[]': 'type-portfolio',
            },
        }).
                success(function(data, status, headers, config) {
                    $scope.posts = data;
                }).
                error(function(data, status, headers, config) {
                });
    }]);


myapp.directive('mySearchForm', [ '$location', function($location) {
    return {
        restrict: 'EA',
        template: 'Recherche : <input type="text" name="s" ng-model="filter.s" ng-change="search()">',
        controller: function($scope, $http) {
            $scope.filter = {
                s: '',
                type: 'post',
            };
            if($location.$$path == '/portfolio'){
                $scope.filter.type = 'type-portfolio';
            }            
            $scope.search = function() {
                $http({
                    method: 'GET',
                    url: $scope.api + '/posts',
                    params: {
                        'filter[s]': $scope.filter.s,
                        'type[]': $scope.filter.type,
                    },
                }).
                        success(function(data, status, headers, config) {
                            $scope.posts = data;
                        }).
                        error(function(data, status, headers, config) {
                        });
            }
        }
    };
}]);
