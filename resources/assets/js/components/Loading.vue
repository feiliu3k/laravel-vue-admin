<template>
    <div class="progress" :style="{
    width: `${percent}%`,
    height: height,
    opacity: show ? 1 : 0,
    'background-color': canSuccess ? color : failedColor
  }"></div>
</template>

<script lang="ts">
    // https://github.com/nuxt/nuxt.js/blob/master/lib/app/components/nuxt-loading.vue
    import Vue from 'vue';
    import Component from 'vue-class-component'
    import {mapGetters, mapActions} from "vuex";

    export default class Loading extends Vue {
        public percent: number = 0;
        public show: boolean = false;
        public canSuccess: boolean = true;
        public duration: number = 3000;
        public color: string = "#77b6ff"
        public height: string = '2px';
        public failedColor: string = 'red';
        private _timer: number | null;
        private _cut: number = 0;

        public start(): Loading {
            this.show = true;
            this.canSuccess = true;
            if (this._timer) {
                clearInterval(this._timer);
                this.percent = 0;
            }
            this._cut = 10000 / Math.floor(this.duration);
            this._timer = setInterval(() => {
                this.increase(this._cut * Math.random());
                if (this.percent > 95) {
                    this.finish();
                }
            }, 100);
            return this;
        }

        public set(num: number): Loading {
            this.show = true;
            this.canSuccess = true;
            this.percent = Math.floor(num);
            return this;
        }

        public get(): number {
            return Math.floor(this.percent);
        }

        public increase(num: number): Loading {
            this.percent = this.percent + Math.floor(num);
            return this;
        }

        public decrease(num: number): Loading {
            this.percent = this.percent - Math.floor(num);
            return this;
        }

        public finish(): Loading {
            this.percent = 100;
            this.hide();
            return this;
        }

        public pause(): Loading {
            clearInterval(this._timer as number)
            return this;
        }

        public hide(): Loading {
            clearInterval(this._timer as number);
            this._timer = null;
            setTimeout(() => {
                this.show = false;
                Vue.nextTick((): void => {
                    setTimeout((): void => {
                        this.percent = 0;
                    }, 200);
                });
            }, 500);
            return this;
        }

        public fail(): Loading {
            this.canSuccess = false;
            return this;
        }
    }
</script>

<style scoped>
    .progress {
        position: fixed;
        top: 0px;
        left: 0px;
        right: 0px;
        height: 2px;
        width: 0%;
        transition: width 0.2s, opacity 0.4s;
        opacity: 1;
        background-color: #efc14e;
        z-index: 999999;
    }
</style>
