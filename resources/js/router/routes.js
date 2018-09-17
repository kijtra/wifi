const Home = () => import('~/pages/home').then(m => m.default || m)

const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const User = () => import('~/pages/user/index').then(m => m.default || m)
const UserProfile = () => import('~/pages/user/profile').then(m => m.default || m)
const UserPassword = () => import('~/pages/user/password').then(m => m.default || m)

export default [
  { path: '/', name: 'home', component: Home },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/user',
    component: User,
    children: [
      { path: '', name: 'user', component: User },
      { path: 'profile', name: 'user.profile', component: UserProfile },
      { path: 'password', name: 'user.password', component: UserPassword }
    ] },

  { path: '*', component: NotFound }
]
