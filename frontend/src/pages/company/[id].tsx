import { Box, Container, Typography } from '@mui/material';
import type { NextPage } from 'next';
import ArticleCard from '@/components/ArticleCard';

type ArticleProps = {
  id: number;
  title: string;
  content: string;
};

const Index: NextPage = () => {
  const articles: ArticleProps[] = [
    {
      id: 1,
      title: "1番目の記事",
      content: "記事の要約1",
    },
    {
      id: 2,
      title: "2番目の記事",
      content: "記事の要約2",
    },
    // 他の記事データを追加...
  ];

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh' }}>
      <Container maxWidth="md" sx={{ pt: 6 }}>
        <Typography variant="h3" component="h1" sx={{ textAlign: 'center', my: 4, color: 'text.primary' }}>
          記事タイトルと要約
        </Typography>
        {articles.map((article) => (
          <Box key={article.id} sx={{ mb: 4, bgcolor: 'white' }}>
            <ArticleCard {...article} />
          </Box>
        ))}
      </Container>
    </Box>
  );
};

export default Index;
