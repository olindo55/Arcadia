export default class Service{
    name;
    description;
    image_url; 
    image_alt; 

    constructor(name, description, image_url, image_alt){
        this.name = name;
        this.description = description;
        this.image_url = image_url;
        this.image_alt = image_alt;
    }
    getService(){
        const service = [this.name, this.description, this.image_url, this.image_alt];
        return service;
    }
}