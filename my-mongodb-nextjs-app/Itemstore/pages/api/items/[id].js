import { ObjectId } from 'mongodb';
import clientPromise from '../../../lib/mongodb';

export default async function handler(req, res) {
  const client = await clientPromise;
  const db = client.db();
  const { id } = req.query;

  switch (req.method) {
    case 'PUT':
      const { name, date_bought, check_date, warranty_years, expiry_date } = req.body;
      const result = await db.collection('items').updateOne(
        { _id: new ObjectId(id) },
        { $set: { name, date_bought, check_date, warranty_years, expiry_date } }
      );
      res.status(200).json(result);
      break;
    case 'DELETE':
      const deleteResult = await db.collection('items').deleteOne({ _id: new ObjectId(id) });
      res.status(200).json(deleteResult);
      break;
    default:
      res.setHeader('Allow', ['PUT', 'DELETE']);
      res.status(405).end(`Method ${req.method} Not Allowed`);
      break;
  }
}