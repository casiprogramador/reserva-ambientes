class AppStorage{
    storeToken(token){
        return localStorage.setItem('token',token);
    }

    storeUser(user){
        return localStorage.setItem('user',JSON.stringify(user));
    }

    store(user,token){
        this.storeToken(token);
        this.storeUser(user);
    }

    clear(){
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    }

    getToken(){
        return localStorage.getItem('token');
    }

    getUser(){
        return JSON.parse(localStorage.getItem('user'));
    }
}

export default AppStorage = new AppStorage();