export default class Biome{
    name;
    description;
    image_url; 
    image_url_hd; 
    image_alt; 

    constructor(name, description, image_url, image_url_hd, image_alt){
        this.name = name;
        this.description = description;
        this.image_url = image_url;
        this.image_url_hd = image_url_hd;
        this.image_alt = image_alt;
    }
    getBiome(){
        const biome = [this.name, this.description, this.image_url, this.image_url_hd, this.image_alt];
        return biome;
    }
}