import { useState, useEffect } from 'react';
import axios from 'axios';

export default function Home() {
  const [items, setItems] = useState([]);
  const [form, setForm] = useState({
    name: '',
    date_bought: '',
    check_date: '',
    warranty_years: '',
    expiry_date: '',
  });

  useEffect(() => {
    fetchItems();
  }, []);

  const fetchItems = async () => {
    const response = await axios.get('/api/items');
    setItems(response.data);
  };

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await axios.post('/api/items', form);
    setForm({
      name: '',
      date_bought: '',
      check_date: '',
      warranty_years: '',
      expiry_date: '',
    });
    fetchItems();
  };

  const handleUpdate = async (id) => {
    const updatedItem = items.find((item) => item._id === id);
    await axios.put(`/api/items/${id}`, updatedItem);
    fetchItems();
  };

  const handleDelete = async (id) => {
    await axios.delete(`/api/items/${id}`);
    fetchItems();
  };

  return (
    <div>
      <h1>Item Tracker</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          name="name"
          placeholder="Item Name"
          value={form.name}
          onChange={handleChange}
        />
        <input
          type="date"
          name="date_bought"
          value={form.date_bought}
          onChange={handleChange}
        />
        <input
          type="date"
          name="check_date"
          value={form.check_date}
          onChange={handleChange}
        />
        <input
          type="number"
          name="warranty_years"
          placeholder="Warranty Years"
          value={form.warranty_years}
          onChange={handleChange}
        />
        <input
          type="date"
          name="expiry_date"
          value={form.expiry_date}
          onChange={handleChange}
        />
        <button type="submit">Add Item</button>
      </form>
      <ul>
        {items.map((item) => (
          <li key={item._id}>
            {item.name} - {item.date_bought} - {item.check_date} - {item.warranty_years} years - {item.expiry_date}
            <button onClick={() => handleUpdate(item._id)}>Update</button>
            <button onClick={() => handleDelete(item._id)}>Delete</button>
          </li>
        ))}
      </ul>
    </div>
  );
}