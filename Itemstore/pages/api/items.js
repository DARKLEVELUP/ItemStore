import clientPromise from '../../lib/mongodb';

export default async function handler(req, res) {
  const client = await clientPromise;
  const db = client.db();

  switch (req.method) {
    case 'POST':
      const { name, date_bought, check_date, warranty_years, expiry_date } = req.body;
      const newItem = {
        name,
        date_bought,
        check_date,
        warranty_years,
        expiry_date,
      };
      const result = await db.collection('items').insertOne(newItem);
      res.status(201).json(result.ops[0]);
      break;
    case 'GET':
      const items = await db.collection('items').find({}).toArray();
      res.status(200).json(items);
      break;
    default:
      res.setHeader('Allow', ['GET', 'POST']);
      res.status(405).end(`Method ${req.method} Not Allowed`);
      break;
  }
}