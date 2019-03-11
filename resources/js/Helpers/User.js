import AppStorage from './AppStorage'

class User{
    login(data){
        axios.post('/api/auth/login',data)
        .then(res => this.resposeAfterLogin(res))
        .catch(error=> console.log(error.response))
    }

    resposeAfterLogin(res){
        const access_token = res.data.access_token
        const user = res.data.user
        AppStorage.store(user,access_token)
    }

    hasToken(){
        const storedToken = AppStorage.getToken();
        if(storedToken){
            return true
        }
        return false
    }

    loggedIn(){
        return this.hasToken();
    }

    logout(){
        AppStorage.clear()
        window.location.reload()
    }

    nameUser(){
        if(this.loggedIn()){
            return AppStorage.getUser();
        }
    }
}

export default User = new User();