var classes = [
    {
        "name": "Paprika\\utils\\LoggedPDOStatement",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "execute",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 2,
        "nbMethodsPrivate": 1,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 2,
        "ccn": 1,
        "ccnMethodMax": 1,
        "externals": [
            "PDOStatement",
            "Monolog\\Logger"
        ],
        "parents": [
            "PDOStatement"
        ],
        "implements": [],
        "lcom": 1,
        "length": 21,
        "vocabulary": 9,
        "volume": 66.57,
        "difficulty": 2.29,
        "effort": 152.16,
        "level": 0.44,
        "bugs": 0.02,
        "time": 8,
        "intelligentContent": 29.12,
        "number_operators": 5,
        "number_operands": 16,
        "number_operators_unique": 2,
        "number_operands_unique": 7,
        "cloc": 3,
        "loc": 24,
        "lloc": 21,
        "mi": 84.29,
        "mIwoC": 58.26,
        "commentWeight": 26.04,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 9,
        "relativeDataComplexity": 0.63,
        "relativeSystemComplexity": 9.63,
        "totalStructuralComplexity": 18,
        "totalDataComplexity": 1.25,
        "totalSystemComplexity": 19.25,
        "package": "Paprika\\utils\\",
        "pageRank": 0.02,
        "afferentCoupling": 0,
        "efferentCoupling": 2,
        "instability": 1,
        "violations": {}
    },
    {
        "name": "Paprika\\utils\\LoggedPDO",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 1,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 1,
        "ccn": 1,
        "ccnMethodMax": 1,
        "externals": [
            "PDO",
            "Paprika\\utils\\SingletonLogger"
        ],
        "parents": [
            "PDO"
        ],
        "implements": [],
        "lcom": 1,
        "length": 13,
        "vocabulary": 7,
        "volume": 36.5,
        "difficulty": 0,
        "effort": 0,
        "level": 1.08,
        "bugs": 0.01,
        "time": 0,
        "intelligentContent": 39.3,
        "number_operators": 0,
        "number_operands": 13,
        "number_operators_unique": 0,
        "number_operands_unique": 7,
        "cloc": 1,
        "loc": 11,
        "lloc": 10,
        "mi": 89.63,
        "mIwoC": 67.11,
        "commentWeight": 22.51,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 16,
        "relativeDataComplexity": 0.8,
        "relativeSystemComplexity": 16.8,
        "totalStructuralComplexity": 16,
        "totalDataComplexity": 0.8,
        "totalSystemComplexity": 16.8,
        "package": "Paprika\\utils\\",
        "pageRank": 0.03,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "violations": {}
    },
    {
        "name": "Paprika\\utils\\SingletonDataBaseMariaDB",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getInstance",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getPDO",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getLoggedPDO",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 4,
        "nbMethods": 2,
        "nbMethodsPrivate": 1,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 2,
        "nbMethodsSetters": 0,
        "wmc": 3,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Paprika\\utils\\SingletonConfigReader",
            "PDO",
            "Paprika\\utils\\LoggedPDO",
            "PDO",
            "Paprika\\utils\\LoggedPDO"
        ],
        "parents": [],
        "implements": [],
        "lcom": 2,
        "length": 36,
        "vocabulary": 11,
        "volume": 124.54,
        "difficulty": 6.86,
        "effort": 853.99,
        "level": 0.15,
        "bugs": 0.04,
        "time": 47,
        "intelligentContent": 18.16,
        "number_operators": 12,
        "number_operands": 24,
        "number_operators_unique": 4,
        "number_operands_unique": 7,
        "cloc": 2,
        "loc": 34,
        "lloc": 32,
        "mi": 70.57,
        "mIwoC": 52.23,
        "commentWeight": 18.35,
        "kanDefect": 0.22,
        "relativeStructuralComplexity": 9,
        "relativeDataComplexity": 0.75,
        "relativeSystemComplexity": 9.75,
        "totalStructuralComplexity": 36,
        "totalDataComplexity": 3,
        "totalSystemComplexity": 39,
        "package": "Paprika\\utils\\",
        "pageRank": 0.03,
        "afferentCoupling": 1,
        "efferentCoupling": 3,
        "instability": 0.75,
        "violations": {}
    },
    {
        "name": "Paprika\\utils\\SingletonConfigReader",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getInstance",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getValue",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 3,
        "nbMethods": 3,
        "nbMethodsPrivate": 1,
        "nbMethodsPublic": 2,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 9,
        "ccn": 7,
        "ccnMethodMax": 4,
        "externals": [
            "Exception",
            "Exception",
            "Paprika\\utils\\SingletonConfigReader"
        ],
        "parents": [],
        "implements": [],
        "lcom": 2,
        "length": 32,
        "vocabulary": 14,
        "volume": 121.84,
        "difficulty": 6.38,
        "effort": 776.7,
        "level": 0.16,
        "bugs": 0.04,
        "time": 43,
        "intelligentContent": 19.11,
        "number_operators": 15,
        "number_operands": 17,
        "number_operators_unique": 6,
        "number_operands_unique": 8,
        "cloc": 13,
        "loc": 44,
        "lloc": 31,
        "mi": 89.22,
        "mIwoC": 51.92,
        "commentWeight": 37.3,
        "kanDefect": 0.43,
        "relativeStructuralComplexity": 0,
        "relativeDataComplexity": 3.67,
        "relativeSystemComplexity": 3.67,
        "totalStructuralComplexity": 0,
        "totalDataComplexity": 11,
        "totalSystemComplexity": 11,
        "package": "Paprika\\utils\\",
        "pageRank": 0.05,
        "afferentCoupling": 4,
        "efferentCoupling": 3,
        "instability": 0.43,
        "violations": {}
    },
    {
        "name": "Paprika\\utils\\SingletonLogger",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getInstance",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getSQLLogger",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getErrorLogger",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 4,
        "nbMethods": 2,
        "nbMethodsPrivate": 1,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 2,
        "nbMethodsSetters": 0,
        "wmc": 4,
        "ccn": 3,
        "ccnMethodMax": 2,
        "externals": [
            "Paprika\\utils\\SingletonConfigReader",
            "Monolog\\Logger",
            "Monolog\\Handler\\StreamHandler",
            "Monolog\\Logger",
            "Monolog\\Handler\\StreamHandler",
            "Paprika\\utils\\SingletonLogger",
            "Paprika\\utils\\SingletonLogger",
            "Monolog\\Logger",
            "Monolog\\Logger"
        ],
        "parents": [],
        "implements": [],
        "lcom": 2,
        "length": 56,
        "vocabulary": 25,
        "volume": 260.06,
        "difficulty": 3.81,
        "effort": 990.69,
        "level": 0.26,
        "bugs": 0.09,
        "time": 55,
        "intelligentContent": 68.26,
        "number_operators": 16,
        "number_operands": 40,
        "number_operators_unique": 4,
        "number_operands_unique": 21,
        "cloc": 5,
        "loc": 53,
        "lloc": 48,
        "mi": 68.92,
        "mIwoC": 46.01,
        "commentWeight": 22.9,
        "kanDefect": 0.29,
        "relativeStructuralComplexity": 9,
        "relativeDataComplexity": 1.25,
        "relativeSystemComplexity": 10.25,
        "totalStructuralComplexity": 36,
        "totalDataComplexity": 5,
        "totalSystemComplexity": 41,
        "package": "Paprika\\utils\\",
        "pageRank": 0.05,
        "afferentCoupling": 3,
        "efferentCoupling": 5,
        "instability": 0.63,
        "violations": {}
    },
    {
        "name": "Paprika\\model\\DAOCaserne",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "find",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "save",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "update",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "delete",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "findAll",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "count",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "findByCity",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "generateNextId",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 9,
        "nbMethods": 8,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 8,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 1,
        "wmc": 11,
        "ccn": 4,
        "ccnMethodMax": 2,
        "externals": [
            "PDO",
            "Paprika\\model\\Caserne",
            "Paprika\\model\\Caserne"
        ],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 113,
        "vocabulary": 33,
        "volume": 570.02,
        "difficulty": 6.34,
        "effort": 3616.66,
        "level": 0.16,
        "bugs": 0.19,
        "time": 201,
        "intelligentContent": 89.84,
        "number_operators": 21,
        "number_operands": 92,
        "number_operators_unique": 4,
        "number_operands_unique": 29,
        "cloc": 1,
        "loc": 57,
        "lloc": 56,
        "mi": 52.22,
        "mIwoC": 42.03,
        "commentWeight": 10.19,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 169,
        "relativeDataComplexity": 0.63,
        "relativeSystemComplexity": 169.63,
        "totalStructuralComplexity": 1521,
        "totalDataComplexity": 5.64,
        "totalSystemComplexity": 1526.64,
        "package": "Paprika\\model\\",
        "pageRank": 0.02,
        "afferentCoupling": 0,
        "efferentCoupling": 2,
        "instability": 1,
        "violations": {}
    },
    {
        "name": "Paprika\\model\\DAOPompiers",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "find",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "save",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "update",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "delete",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "findAll",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "count",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "findByGrade",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "keyGenerator",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 9,
        "nbMethods": 8,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 8,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 1,
        "wmc": 24,
        "ccn": 17,
        "ccnMethodMax": 5,
        "externals": [
            "PDO",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Paprika\\model\\Pompiers",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Paprika\\model\\Pompiers",
            "Exception",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Paprika\\model\\Pompiers",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Exception",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Paprika\\model\\Pompiers",
            "Paprika\\utils\\SingletonDataBaseMariaDB",
            "Exception"
        ],
        "parents": [],
        "implements": [],
        "lcom": 6,
        "length": 345,
        "vocabulary": 60,
        "volume": 2037.88,
        "difficulty": 22.94,
        "effort": 46751.3,
        "level": 0.04,
        "bugs": 0.68,
        "time": 2597,
        "intelligentContent": 88.83,
        "number_operators": 85,
        "number_operands": 260,
        "number_operators_unique": 9,
        "number_operands_unique": 51,
        "cloc": 58,
        "loc": 220,
        "lloc": 162,
        "mi": 62.05,
        "mIwoC": 26.34,
        "commentWeight": 35.71,
        "kanDefect": 0.96,
        "relativeStructuralComplexity": 400,
        "relativeDataComplexity": 0.8,
        "relativeSystemComplexity": 400.8,
        "totalStructuralComplexity": 3600,
        "totalDataComplexity": 7.19,
        "totalSystemComplexity": 3607.19,
        "package": "Paprika\\model\\",
        "pageRank": 0.02,
        "afferentCoupling": 0,
        "efferentCoupling": 4,
        "instability": 1,
        "violations": {}
    },
    {
        "name": "Paprika\\model\\Pompiers",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getMatricule",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getPrenom",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getNom",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getChefAgret",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getDateNaissance",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getNumCaserne",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getCodeGrade",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getMatriculeRespo",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getDeleted",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setMatricule",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setPrenom",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setNom",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setChefAgret",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setDateNaissance",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setNumCaserne",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setCodeGrade",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setMatriculeRespo",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setDeleted",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 19,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 9,
        "nbMethodsSetters": 9,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "stdClass",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers",
            "Paprika\\model\\Pompiers"
        ],
        "parents": [
            "stdClass"
        ],
        "implements": [],
        "lcom": 1,
        "length": 112,
        "vocabulary": 14,
        "volume": 426.42,
        "difficulty": 10.09,
        "effort": 4303,
        "level": 0.1,
        "bugs": 0.14,
        "time": 239,
        "intelligentContent": 42.26,
        "number_operators": 38,
        "number_operands": 74,
        "number_operators_unique": 3,
        "number_operands_unique": 11,
        "cloc": 5,
        "loc": 115,
        "lloc": 110,
        "mi": 52.66,
        "mIwoC": 36.79,
        "commentWeight": 15.87,
        "kanDefect": 0.22,
        "relativeStructuralComplexity": 0,
        "relativeDataComplexity": 18.89,
        "relativeSystemComplexity": 18.89,
        "totalStructuralComplexity": 0,
        "totalDataComplexity": 359,
        "totalSystemComplexity": 359,
        "package": "Paprika\\model\\",
        "pageRank": 0.73,
        "afferentCoupling": 3,
        "efferentCoupling": 3,
        "instability": 0.5,
        "violations": {}
    },
    {
        "name": "Paprika\\model\\Caserne",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "getNumCaserne",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setNumCaserne",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getAdresse",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setAdresse",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getCp",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setCp",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getVille",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setVille",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getCodeTypeC",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setCodeTypeC",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setDeleted",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isDeleted",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 12,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 5,
        "nbMethodsSetters": 6,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 51,
        "vocabulary": 11,
        "volume": 176.43,
        "difficulty": 6,
        "effort": 1058.59,
        "level": 0.17,
        "bugs": 0.06,
        "time": 59,
        "intelligentContent": 29.41,
        "number_operators": 19,
        "number_operands": 32,
        "number_operators_unique": 3,
        "number_operands_unique": 8,
        "cloc": 1,
        "loc": 65,
        "lloc": 64,
        "mi": 54.15,
        "mIwoC": 44.6,
        "commentWeight": 9.55,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 0,
        "relativeDataComplexity": 12.5,
        "relativeSystemComplexity": 12.5,
        "totalStructuralComplexity": 0,
        "totalDataComplexity": 150,
        "totalSystemComplexity": 150,
        "package": "Paprika\\model\\",
        "pageRank": 0.04,
        "afferentCoupling": 1,
        "efferentCoupling": 0,
        "instability": 0,
        "violations": {}
    }
]