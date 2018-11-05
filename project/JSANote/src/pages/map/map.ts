import { Component , ViewChild, ElementRef} from '@angular/core';
import { IonicPage, LoadingController, NavController, NavParams, Navbar } from 'ionic-angular';
import 'leaflet';
import { Geolocation } from '@ionic-native/geolocation';
import L, { LatLngExpression } from 'leaflet';
import { Note } from '../../model/note/note.model';
import { NoteListService } from '../../services/note-list.service';
// import * as mapmarker from './map.js';

/**
 * Generated class for the MapPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-map',
  templateUrl: 'map.html',
})
export class MapPage {
  @ViewChild('map') mapContainer: ElementRef;
  map: any;
  newlat
  newlng
  newcost
  newitems
  newloc
  // note: Note = {
  //   items: '',
  //   cost: undefined,
  //   loc: '',
  //   lat: undefined,
  //   lng: undefined
  // };

  loading;
  constructor(private loadingCtrl: LoadingController, public navCtrl: NavController, public navParams: NavParams, private gl: Geolocation) {
    /**
     * Map takes a bit to load once the page is opened. 
     * So we show a loading spinner to the user until the map is completely loaded.
     * We use Ionic's loading controller. Link: https://ionicframework.com/docs/api/components/loading/LoadingController/
     */
    this.presentLoading();
  }

  ionViewDidLoad() {
    // this.note = this.navParams.get('note');
    // console.log("cost = "+this.navParams.get('cost'));
    this.newcost = this.navParams.get('cost');
    this.newitems = this.navParams.get('items');
    this.newloc = this.navParams.get('loc');
    console.log('ionViewDidLoad MapPage');
    var planes = [
      ["User1",26.50507,80.22928],
      ["User2",26.50509,80.22926],
      ["User3",26.50503,80.22921],
      ["User4",26.50505,80.22929],
      ["User5",26.50503,80.22926],
      ["User6",26.50507,80.22921],
      ["User7",26.50509,80.22923],
      ["User8",26.50504,80.22922],
      ["User9",26.50505,80.22924]
      ];
    // var planes = [
    //   {lat: 30.99497, lng: 76.50808},
    //   {lat: 31.30269, lng: 76.63696}
    // ];
    var map  = L.map("map").fitWorld();

    /**
     * Apparently you don't need any tokens to use the maps. 
     */
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attributions: 'www.tphangout.com',
      maxZoom: 24
    }).addTo(map);
    var mylat,mylng;
    
    map.locate({
      setView: true, 
      maxZoom: 18
    })
    .on('locationfound', (e) => {
      this.loading.dismiss(); //Stop showing the loading spinner once the map is loaded.
      const { lat, lng } = e.target.getCenter();
      mylat = lat;
      mylng = lng;
      console.log(mylat + " " + mylng);
      let markerGroup = L.featureGroup();
      let marker: any = L.marker([lat,lng])
      .bindPopup('My Location');
      // .openPopup()
      // .on('click',() => {
        // alert("hey there");
        // alert(lat);
        // alert(lng);
      // })
      // marker.draggable = true;
      markerGroup.addLayer(marker);
      // marker = L.marker([29,77])
      // markerGroup.addLayer(marker);
      map.addLayer(markerGroup);
      

      // console.log(lat);
      }).on('locationerror', (err) => {
        alert("error");
    })
    // console.log(mylat + " " + mylng);
    // console.log("coming here");
    // L.marker([26.5005, 80.225]).addTo(map)
    // .bindPopup('Location of<br>another user');

    for (var i = 0; i < planes.length; i++) {
      var l1 = planes[i][1];
      var l2 = planes[i][2];
			L.marker([<number>l1,<number>l2])
				.bindPopup(<string>planes[i][0])
				.addTo(map);
    }

    // map.on('click', function(ev){
    //   var latlng = map.mouseEventToLatLng(ev.originalEvent);
    //   console.log(latlng.lat + ', ' + latlng.lng);
    // });

    // map.on('click', function(e){

    map.on('click', <LeafletMouseEvent>(e) => {
      // var coord = e.target.getCenter(1);
      var coord = e.latlng;
      // var lat = Math.round(coord.lat*100)/100;
      // var lng = Math.round(coord.lng*100)/100;
      var lat = coord.lat;
      var lng = coord.lng;
      this.newlat = lat;
      this.newlng = lng;
      console.log("Click at latitude: " + lat + " and longitude: " + lng);
      // alert("You clicked the map at latitude: "+lat+" and longitude: "+lng);
      // findNearestMarker(coord);
      });

    // var coords = [{ lat:60.1697, lng:24.8292},
    //   { lat: 60.1704, lng: 24.8285 },
    //   { lat: 60.1709, lng: 24.8277 },
    //   { lat: 60.1700, lng: 24.8265 },
    // { lat:60.1700, lng: 24.8283}];
    
    function findNearestMarker(coords) {
      var minDist = 1000,
        nearest_text = '*None*',
        markerDist;
        var nearest = [];
      
      // iterate over objects and calculate distance between them
      for (var i = 0; i < planes.length; i += 1) {
        // markerDist = objects[i].getPosition().distance(coords);
        var latlng = L.latLng(<number>planes[i][1],<number>planes[i][2])
        markerDist = L.latLng(coords).distanceTo(latlng);
        if (markerDist < minDist) {
          minDist = markerDist;
          nearest_text = <string>planes[i][0];
        }
        var text = <string>planes[i][0];
        if(markerDist<50){
          nearest.push(text);
          // alert("Marker within 50 metres is/are: " + text);
        }
      }
      // nearest.sort();
      console.log("Nearest 50 metre markers are: " + nearest.length);
      for(var i = 0; i<nearest.length; i++){
        console.log(nearest[i]);
      }
      console.log("The nearest marker is " + nearest_text);
      // alert('The nearest marker is: ' + nearest_text);
      // console.log(mylat + " " + mylng);
    }

  }

  presentLoading() {
    this.loading = this.loadingCtrl.create({
      content: 'Loading map...'
    });

    this.loading.present();
  }

  goback(){
    let data = {
      items : this.newitems,
      cost : this.newcost,
      loc : this.newloc,
      lat : this.newlat,
      lng : this.newlng
    }
    this.navCtrl.setRoot('AddNotePage',data);
  }
}