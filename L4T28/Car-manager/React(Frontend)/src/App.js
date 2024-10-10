import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './App.css'; // Import CSS file for styling

axios.defaults.baseURL = 'http://localhost:8080';

const App = () => {
  const [cars, setCars] = useState([]); // State to store list of cars
  const [newCar, setNewCar] = useState({ make: '', model: '', seats: 0 }); // State to manage new car form input
  const [editCar, setEditCar] = useState(null); // State to manage the car being edited
  const [error, setError] = useState(''); // State to handle error messages

  useEffect(() => {
    fetchCars(); // Fetch the list of cars when the component mounts
  }, []);

  // Function to fetch cars from the API
  const fetchCars = async () => {
    try {
      const response = await axios.get('/api');
      setCars(response.data);
    } catch (error) {
      console.error('Error fetching cars:', error);
      setError('Error fetching cars. Please try again later.');
    }
  };

  // Event handler for input changes in the new car form
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setNewCar((prevCar) => ({ ...prevCar, [name]: value }));
  };

  // Event handler for input changes in the edit car form
  const handleEditInputChange = (e) => {
    const { name, value } = e.target;
    setEditCar((prevCar) => ({ ...prevCar, [name]: value }));
  };

  // Function to add a new car to the inventory
  const addCar = async () => {
    try {
      const response = await axios.post('/api', newCar);
      setCars((prevCars) => [...prevCars, response.data]);
      setNewCar({ make: '', model: '', seats: 0 });
    } catch (error) {
      console.error('Error adding car:', error);
      setError('Error adding car. Please try again later.');
    }
  };

  // Function to delete a car from the inventory
  const deleteCar = async (id) => {
    try {
      await axios.delete(`/api/${id}`);
      setCars((prevCars) => prevCars.filter((car) => car.id !== id));
    } catch (error) {
      console.error('Error deleting car:', error);
      setError('Error deleting car. Please try again later.');
    }
  };

  // Function to update details of a car in the inventory
  const updateCar = async (id, updatedCar) => {
    try {
      const response = await axios.put(`/api/${id}`, updatedCar);
      setCars((prevCars) =>
        prevCars.map((car) => (car.id === id ? response.data : car))
      );
      setEditCar(null); // Reset edit form
    } catch (error) {
      console.error('Error updating car:', error);
      setError('Error updating car. Please try again later.');
    }
  };

  // Function to handle the update button click
  const handleUpdateClick = (car) => {
    setEditCar(car); // Set the car to be edited
  };

  return (
    <div className="container">
      <h1>Car Inventory</h1>
      {error && <div className="error">{error}</div>}
      <ul>
        {/* Render list of cars */}
        {cars.map((car) => (
          <li key={car.id}>
            <span>{car.make}</span>
            <span>{car.model}</span>
            <span>Seats: {car.seats}</span>
            <button onClick={() => deleteCar(car.id)}>Delete</button>
            <button onClick={() => handleUpdateClick(car)}>Update</button>
          </li>
        ))}
      </ul>
      <h2>Add New Car</h2>
      {/* Form for adding a new car */}
      <input
        type="text"
        name="make"
        placeholder="Make"
        value={newCar.make}
        onChange={handleInputChange}
      />
      <input
        type="text"
        name="model"
        placeholder="Model"
        value={newCar.model}
        onChange={handleInputChange}
      />
      <input
        type="number"
        name="seats"
        placeholder="Seats"
        value={newCar.seats}
        onChange={handleInputChange}
      />
      <button onClick={addCar}>Add Car</button>

      {/* Form for editing an existing car */}
      {editCar && (
        <div>
          <h2>Edit Car</h2>
          <input
            type="text"
            name="make"
            placeholder="Make"
            value={editCar.make}
            onChange={handleEditInputChange}
          />
          <input
            type="text"
            name="model"
            placeholder="Model"
            value={editCar.model}
            onChange={handleEditInputChange}
          />
          <input
            type="number"
            name="seats"
            placeholder="Seats"
            value={editCar.seats}
            onChange={handleEditInputChange}
          />
          <button onClick={() => updateCar(editCar.id, editCar)}>Save</button>
          <button onClick={() => setEditCar(null)}>Cancel</button>
        </div>
      )}
    </div>
  );
};

export default App;
