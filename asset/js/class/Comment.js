export default class Comment{
    pseudo;
    comment;
    date_comment; 
    score; 
    published;
    approver;

    constructor(id, pseudo, comment, date_comment, score, published, approver){
        this.id = id;
        this.pseudo = pseudo;
        this.comment = comment;
        this.date_comment = date_comment;
        this.score = score;
        this.published = published;
        this.approver = approver;
    }
    getService(){
        const comment = [this.id, this.pseudo, this.comment, this.date_comment, this.score, this.published, this.approver];
        return comment;
    }
}