import Main from "../page/Main.vue";
import Dashboard from '../Dashboard.vue'
import PermissionMain from '../page/admin/permission/main.vue'
import Category from '../page/admin/content/Category.vue'
import PatternPage from '../page/admin/content/PatternPage.vue'

export default [
    {
        path: '/',
        name: '首页',
        component: Main,
        hidden: true,
        redirect: '/profile',
        children: [
            {
                path: '/profile',
                name: '个人中心',
                component: Dashboard,
            },

            {
                path: '/content',
                name: '内容管理',
                component: Dashboard,
                redirect: '/content/category',
                children: [
                    {
                        path: 'category',
                        name: '分类管理',
                        component: Category
                    },
                    {

                        path: 'pattern',
                        name: '模型管理',
                        component: PatternPage
                    }
                ]
            },
            {
                path: '/system',
                name: '系统管理',
                component: Dashboard,
                redirect: '/system/permission',
                children: [
                    {
                        path: 'permission',
                        name: '权限',
                        component: PermissionMain
                    }
                ]

            }
        ]
    },


];