<template>
    <div class="container">
        <div v-bind:class="{wrap : edit}">
            <textarea :value="input" @input="update" class="editor" name="body" v-show="edit"></textarea>
            <div v-html="compiledMarkdown"></div>
        </div>
    </div>
</template>

<script>
    import * as marked from "marked";
    export default {
        props: ['value', 'edit'],

        data() {
            return {
                input: this.value
            }
        },
        computed: {
            compiledMarkdown: function () {
                return marked(this.input, { sanitize: true })
            }
        },
        methods: {
            update: _.debounce(function (e) {
                this.input = e.target.value
            }, 300)
        }
    }
</script>

<style>
    textarea.editor, .wrap div {
        display: inline-block;
        width: 49%;
        height: 100%;
        vertical-align: top;
        box-sizing: border-box;
        padding: 0 20px;
    }

    textarea.editor {
        border: none;
        border-right: 1px solid #ccc;
        resize: none;
        outline: none;
        background-color: #f6f6f6;
        font-size: 14px;
        font-family: 'Monaco', courier, monospace;
        padding: 20px;
    }

    code {
        color: #f66;
    }
</style>