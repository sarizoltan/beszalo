new Vue({
  el: "#ticket",
  data: {
    airlines: "Amazing Airlines",
    name: "Surname, Firstname",
    boardingTime: "12:00",
    classType: "business",
    gate: "212",
    seat: {
      number: "7kb",
      location: "mid-airplane",
      side: "mirror"
    },
    flight: "EK 457",
    travelTime: "12:45pm",
    travelDate: "23-Jun",
    depart: {
      name: "Dubai",
      code: "DBX"
    },
    arrive: {
      name: "Bombai",
      code: "BOM"
    },
		logo: `<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><path d="M12,23H9.6l-1.7-3.4c-0.2-0.5-0.8-0.7-1.3-0.4c-0.5,0.2-0.7,0.8-0.4,1.3L7.4,23H5c0-0.6-0.4-1-1-1s-1,0.4-1,1v2  c0,0.6,0.4,1,1,1s1-0.4,1-1h2.4l-1.3,2.6c-0.2,0.5,0,1.1,0.4,1.3C6.7,29,6.8,29,7,29c0.4,0,0.7-0.2,0.9-0.6L9.6,25H12  c0.6,0,1-0.4,1-1S12.6,23,12,23z"></path><path d="M15,25h2c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1S14.4,25,15,25z"></path><path d="M20,25h2c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1S19.4,25,20,25z"></path><path d="M20,16h2c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1S19.4,16,20,16z"></path><path d="M25,16c1.1,0,2,0.9,2,2c0,0.6,0.4,1,1,1s1-0.4,1-1c0-2.2-1.8-4-4-4c-0.6,0-1,0.4-1,1S24.4,16,25,16z"></path><path d="M25,25c2.2,0,4-1.8,4-4c0-0.6-0.4-1-1-1s-1,0.4-1,1c0,1.1-0.9,2-2,2c-0.6,0-1,0.4-1,1S24.4,25,25,25z"></path><path d="M20,7h2c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1S19.4,7,20,7z"></path><path d="M15,16h2c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1S14.4,16,15,16z"></path><path d="M15,7h2c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1S14.4,7,15,7z"></path><path d="M12,16c0.6,0,1-0.4,1-1s-0.4-1-1-1c-1.1,0-2-0.9-2-2c0-0.6-0.4-1-1-1s-1,0.4-1,1C8,14.2,9.8,16,12,16z"></path><path d="M9,10c0.6,0,1-0.4,1-1c0-1.1,0.9-2,2-2c0.6,0,1-0.4,1-1s-0.4-1-1-1C9.8,5,8,6.8,8,9C8,9.6,8.4,10,9,10z"></path><path d="M25,7h2c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1S24.4,7,25,7z"></path></svg>`
  }
})