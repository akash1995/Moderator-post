<!doctype html>
<html lang="en">

<head>
    <title>Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>


    <div id="home-app" v-cloak>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <p style="text-align: center;">Section 1</p>
                    <div class="container" v-for="(v,i) in postData">
                        <div @click="detail(v)" style="cursor: pointer;">
                            <p>{{i+1}}) {{v.title}}</p>

                            <div v-for="(k,j) in commentData">
                                <div class="row" v-if="k.id==v.id" style="border: 1px solid #ccc;">
                                    <div class="col-md-6">
                                        <p style="margin: 0; font-weight:bold">{{k.name}}</p>
                                        <p>{{k.comment}}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>status: <span v-if="mode">Moderation</span><span v-if="!mode">Pending</span></p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" v-on:change="checkMode(v)">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button @click="load()">Load</button>


                </div>
                <div class="col-md-4">
                    <p style="text-align: center;">Section 2</p>
                    <div class="container" v-if="sect2">
                        <div>
                            <p><span>{{detailObj.id}})</span>{{detailObj.title}} </p>
                            <p>{{detailObj.body}}</p>
                            <input type="text" v-model="name" placeholder="name">
                            <input type="text" v-model="comment" placeholder="comment"><br><button @click="addComment()">Add Comment</button>
                        </div>
                        <div v-for="(v,i) in commentData">
                            <div v-if="v.id ==id ">
                                <p style="margin: 0; font-weight:600">{{v.name}}</p>
                                <p>{{v.comment}}</p>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <p style="text-align: center;">Section 3</p>
                    <p>Moderation section</p>

                    <div v-for="(k,j) in modeData">
                        <p>{{k.title}}</p>
                        <div class="row" style="border: 1px solid #ccc;">
                            <div class="col-md-6">
                                <p style="margin: 0; font-weight:bold">{{k.name}}</p>
                                <p>{{k.comment}}</p>
                            </div>
                            <div class="col-md-3">
                                <p>status: <span v-if="mode">Moderation</span><span v-if="!mode">Pending</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="global.js"></script>
    <script type="text/javascript">
        var app = new Vue({
            el: '#home-app',
            data: {
                valueOne: 'hello',
                postData: [],
                limit: 10,
                allData: [],
                detailObj: {},
                comment: '',
                name: '',
                id: '',
                commentData: [],
                sect2: false,
                mode: false,
                modeData: [],
            },
            mounted: function() {
                this.getPost()
                console.log(this.detailObj)
            },
            methods: {
                getPost: function() {
                    let t = this;
                    https.get('posts')
                        .then(function(res) {
                            t.allData = res.data;
                            t.allData.forEach(function(value, i) {
                                if (t.postData.length != 10) {
                                    t.postData.push(value)
                                    return t.postData
                                } else {
                                    return t.postData;
                                }

                            })
                            // console.log(t.postData)
                        });
                    console.log(t.postData, 'post ***')

                },
                load: function() {
                    let t = this;
                    console.log(t.allData);
                    for (var i = 1; i <= 10; i++) {
                        t.postData.push(t.allData.slice(9));
                        // console.log(t.postData);
                    }
                },
                detail: function(v) {
                    let t = this;
                    t.sect2 = true;
                    t.detailObj = v;
                    t.id = v.id;
                    console.log('', t.detailObj);
                    // t.detailObj = {}

                },

                addComment: function() {
                    let t = this;

                    t.commentData.push({
                        name: t.name,
                        comment: t.comment,
                        id: t.id
                    })
                    t.comment = '',
                        t.name = '',
                        console.log(t.commentData, 'comment ***')
                },
                checkMode: function(v) {
                    let t = this;
                    t.mode = !t.mode;
                    if (t.mode) {
                        for (i = 0; i < t.commentData.length; i++) {
                            if (t.commentData[i].id === v.id) {

                                t.modeData.push({
                                    title: v.title,
                                    comment: t.commentData[i].comment,
                                    name: t.commentData[i].name
                                });


                            }
                        }
                        console.log(t.modeData)
                    }
                }
            }
        })
    </script>