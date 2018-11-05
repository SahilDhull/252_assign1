import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { Note } from '../../model/note/note.model';
import { NoteListService } from '../../services/note-list.service';
import { MapPage } from '../map/map';

@IonicPage()
@Component({
  selector: 'page-add-note',
  templateUrl: 'add-note.html',
})
export class AddNotePage {

  note: Note = {
    items: '',
    cost: undefined,
    loc: '',
    lat: undefined,
    lng: undefined
  };

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    private noteListService: NoteListService) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad AddNotePage');
    this.note.items = this.navParams.get('items');
    this.note.cost = this.navParams.get('cost');
    this.note.loc = this.navParams.get('loc');
    this.note.lat = this.navParams.get('lat');
    this.note.lng = this.navParams.get('lng');
    console.log(this.note.lat);
  }

  addNote(note: Note) {
    this.noteListService.addNote(note).then(ref => {
      this.navCtrl.setRoot('HomePage');
    })
  }

  loadmap(note: Note){
    // this.navCtrl.push(MapPage,note);
    let data = {
      items : note.items,
      cost : note.cost,
      loc : note.loc,
      lat : note.lat,
      lng : note.lng
    }
    this.navCtrl.setRoot('MapPage',data);
  }

}
